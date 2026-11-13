<?php

namespace Webkul\Lead\Services;

use Exception;
use Smalot\PdfParser\Parser;

class MagicAIService
{
    /**
     * API endpoint for OpenRouter AI service.
     */
    const OPEN_ROUTER_URL = 'https://openrouter.ai/api/v1/chat/completions';

    /**
     * Maximum token limit for AI prompt.
     */
    const MAX_TOKENS = 100000;

    /**
     * Flag to prevent re-entrant calls.
     */
    private static $isExtracting = false;

    /**
     * Extract data from base64-encoded file.
     */
    public static function extractDataFromFile($base64File)
    {
        if (self::$isExtracting) {
            throw new Exception(trans('admin::app.leads.file.recursive-call'));
        }

        self::$isExtracting = true;

        try {
            $text = self::extractTextFromBase64File($base64File);

            if (empty($text)) {
                throw new Exception(trans('admin::app.leads.file.failed-extract'));
            }

            return self::processPromptWithAI($text);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        } finally {
            self::$isExtracting = false;
        }
    }

    /**
     * Extract text from base64-encoded file.
     */
    private static function extractTextFromBase64File($base64File)
    {
        if (
            empty($base64File)
            || ! base64_decode($base64File, true)
        ) {
            throw new Exception(trans('admin::app.leads.file.invalid-base64'));
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'file_');

        file_put_contents($tempFile, self::handleBase64($base64File, 'decode'));

        $mimeType = mime_content_type($tempFile);

        $data = [];

        try {
            if ($mimeType === 'application/pdf') {
                $pdfParser = (new Parser)->parseFile($tempFile);

                $data['text'] = $pdfParser->getText();

                $data['images'][] = '';

                $images = $pdfParser->getObjectsByType('XObject', 'Image');

                foreach ($images as $image) {
                    $data['images'][] = self::handleBase64($image->getContent());
                }
            } else {
                $data['text'] = '';

                $data['images'][] = self::handleBase64(self::handleBase64($base64File, 'decode'));
            }

            if (empty($data)) {
                throw new Exception(trans('admin::app.leads.file.data-extraction-failed'));
            }

            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            @unlink($tempFile);
        }
    }

    /**
     * Send extracted data to AI for processing.
     */
    private static function processPromptWithAI($prompt)
    {
        $model = core()->getConfigData('general.magic_ai.settings.other_model')
            ?: core()->getConfigData('general.magic_ai.settings.model')
            ?: 'google/gemini-2.5-flash';

        $apiKey = core()->getConfigData('general.magic_ai.settings.api_key');

        if (! $apiKey || ! $model) {
            return ['error' => trans('admin::app.leads.file.missing-api-key')];
        }

        $promptText = self::truncatePrompt($prompt['text'] ?? '');

        $promptImages = $prompt['images'] ?? [];

        $prompt = array_filter(array_merge([$promptText], $promptImages), function ($value) {
            return ! empty($value);
        });

        return self::ask(array_values($prompt), $model, $apiKey);
    }

    /**
     * Truncate prompt to fit within token limit.
     */
    private static function truncatePrompt($prompt)
    {
        if (strlen($prompt) > self::MAX_TOKENS) {
            $start = mb_substr($prompt, 0, self::MAX_TOKENS * 0.4);

            $end = mb_substr($prompt, -self::MAX_TOKENS * 0.4);

            return $start."\n...\n".$end;
        }

        return $prompt;
    }

    /**
     * Send prompt request to AI for processing with multi-provider support.
     * Supports direct Google Gemini keys (AIza...), OpenAI keys (sk-...), Anthropic keys (sk-ant-...),
     * and OpenRouter universal router keys (sk-or-...).
     */
    private static function ask($prompt, $model, $apiKey)
    {
        try {
            $apiKey = trim($apiKey);
            $cleanText = is_array($prompt) ? ($prompt[0] ?? '') : $prompt;

            // 1. Native Google Gemini (if key starts with AIza...)
            if (str_starts_with($apiKey, 'AIza')) {
                $geminiModel = str_replace('google/', '', $model);

                // Normalise model identifier for Google AI Studio
                $directUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$geminiModel}:generateContent?key={$apiKey}";
                $response = \Http::withoutVerifying()
                    ->timeout(60)
                    ->withHeaders([
                        'Content-Type' => 'application/json',
                    ])->post($directUrl, [
                        'system_instruction' => [
                            'parts' => [['text' => self::getSystemPrompt()]],
                        ],
                        'contents' => [
                            [
                                'role' => 'user',
                                'parts' => [['text' => $cleanText]],
                            ],
                        ],
                    ]);

                // Fallback to gemini-2.5-flash if the requested model is not found directly in Google AI Studio
                if ($response->status() === 404 && $geminiModel !== 'gemini-2.5-flash') {
                    $response = \Http::withoutVerifying()
                        ->timeout(60)
                        ->withHeaders([
                            'Content-Type' => 'application/json',
                        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                            'system_instruction' => [
                                'parts' => [['text' => self::getSystemPrompt()]],
                            ],
                            'contents' => [
                                [
                                    'role' => 'user',
                                    'parts' => [['text' => $cleanText]],
                                ],
                            ],
                        ]);
                }

                if ($response->failed()) {
                    throw new Exception($response->body());
                }

                $geminiData = $response->json();
                $generatedText = $geminiData['candidates'][0]['content']['parts'][0]['text'] ?? '';

                return [
                    'choices' => [
                        [
                            'message' => [
                                'content' => $generatedText,
                            ],
                        ],
                    ],
                ];
            }

            // 2. Native Anthropic Claude (if key starts with sk-ant-...)
            if (str_starts_with($apiKey, 'sk-ant-')) {
                $claudeModel = str_replace('anthropic/', '', $model);

                $response = \Http::withoutVerifying()
                    ->timeout(60)
                    ->withHeaders([
                        'Content-Type' => 'application/json',
                        'x-api-key' => $apiKey,
                        'anthropic-version' => '2023-06-01',
                    ])->post('https://api.anthropic.com/v1/messages', [
                        'model' => $claudeModel,
                        'max_tokens' => 4096,
                        'system' => self::getSystemPrompt(),
                        'messages' => [
                            [
                                'role' => 'user',
                                'content' => $cleanText,
                            ],
                        ],
                    ]);

                // Fallback to claude-3-7-sonnet-20250219 if experimental model name not recognized directly on Anthropic API
                if ($response->status() === 404 && $claudeModel !== 'claude-3-7-sonnet-20250219') {
                    $response = \Http::withoutVerifying()
                        ->timeout(60)
                        ->withHeaders([
                            'Content-Type' => 'application/json',
                            'x-api-key' => $apiKey,
                            'anthropic-version' => '2023-06-01',
                        ])->post('https://api.anthropic.com/v1/messages', [
                            'model' => 'claude-3-7-sonnet-20250219',
                            'max_tokens' => 4096,
                            'system' => self::getSystemPrompt(),
                            'messages' => [
                                [
                                    'role' => 'user',
                                    'content' => $cleanText,
                                ],
                            ],
                        ]);
                }

                if ($response->failed()) {
                    throw new Exception($response->body());
                }

                $claudeData = $response->json();
                $generatedText = $claudeData['content'][0]['text'] ?? '';

                return [
                    'choices' => [
                        [
                            'message' => [
                                'content' => $generatedText,
                            ],
                        ],
                    ],
                ];
            }

            // 3. Native OpenAI (if key starts with sk-proj- or starts with sk- and NOT sk-or-)
            if (str_starts_with($apiKey, 'sk-proj-') || (str_starts_with($apiKey, 'sk-') && ! str_starts_with($apiKey, 'sk-or-'))) {
                $openaiModel = str_replace('openai/', '', $model);

                $response = \Http::withoutVerifying()
                    ->timeout(60)
                    ->withHeaders([
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer '.$apiKey,
                    ])->post('https://api.openai.com/v1/chat/completions', [
                        'model' => $openaiModel,
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => self::getSystemPrompt(),
                            ],
                            [
                                'role' => 'user',
                                'content' => $cleanText,
                            ],
                        ],
                    ]);

                // Fallback to gpt-4o if the model is not found on direct OpenAI API
                if ($response->status() === 404 && $openaiModel !== 'gpt-4o') {
                    $response = \Http::withoutVerifying()
                        ->timeout(60)
                        ->withHeaders([
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer '.$apiKey,
                        ])->post('https://api.openai.com/v1/chat/completions', [
                            'model' => 'gpt-4o',
                            'messages' => [
                                [
                                    'role' => 'system',
                                    'content' => self::getSystemPrompt(),
                                ],
                                [
                                    'role' => 'user',
                                    'content' => $cleanText,
                                ],
                            ],
                        ]);
                }

                if ($response->failed()) {
                    throw new Exception($response->body());
                }

                return $response->json();
            }

            // 4. Default / OpenRouter (works with OpenRouter sk-or-... keys and all universal models)
            $response = \Http::withoutVerifying()
                ->timeout(60)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$apiKey,
                    'HTTP-Referer' => config('app.url', 'https://nexora.io'),
                    'X-Title' => 'Nexora CRM',
                ])->post(self::OPEN_ROUTER_URL, [
                    'model' => $model,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => self::getSystemPrompt(),
                        ],
                        [
                            'role' => 'user',
                            'content' => $cleanText,
                        ],
                    ],
                ]);

            if ($response->failed()) {
                throw new Exception($response->body());
            }

            $data = $response->json();

            if (isset($data['error'])) {
                $errorMsg = is_array($data['error']) ? ($data['error']['message'] ?? json_encode($data['error'])) : $data['error'];
                throw new Exception($errorMsg);
            }

            return $data;
        } catch (Exception $e) {
            return ['error' => $e->getMessage() ?: trans('admin::app.leads.file.insufficient-info')];
        }
    }

    /**
     * Define system prompt for AI processing.
     *
     * @return string System prompt for AI model.
     */
    private static function getSystemPrompt()
    {
        return <<<'PROMPT'
            You are an AI assistant specialized in extracting structured data from text.  
            The user will provide text extracted from a file (in Base64 or plain text).  
            Your task is to accurately extract the following fields. If the value is not available, use the default values provided:  

            ### **Output Format:** 
            ```json
            {
                "status": 1,
                "title": "Untitled Lead",
                "lead_value": 0,
                "person": {
                    "name": "Unknown",
                    "emails": {
                        "value": null,
                        "label": null
                    },
                    "contact_numbers": {
                        "value": null,
                        "label": null
                    }
                }
            }
            ```
            ### **Fields to Extract:**
            - **Title:** Title of the lead. Default: "Untitled Lead"
            - **Lead Value:** Value of the lead. Default: 0
            - **Person Name:** Name of the person. Default: "Unknown"
            - **Person Email:** Email of the person. Default: null
            - **Person Email Label:** Label for the email. Default: null
            - **Person Contact Number:** Contact number of the person. Default: null
            - **Person Contact Number Label:** Label for the contact number. Default: null
        PROMPT;
    }

    /**
     * process for encoding and decoding base64 data.
     */
    private static function handleBase64($base64, string $type = 'encode')
    {
        if ($type === 'encode') {
            return base64_encode($base64);
        }

        return base64_decode($base64);
    }
}
