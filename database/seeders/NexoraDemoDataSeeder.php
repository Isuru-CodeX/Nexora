<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Webkul\Activity\Models\Activity;
use Webkul\Contact\Models\Organization;
use Webkul\Contact\Models\Person;
use Webkul\Lead\Models\Lead;
use Webkul\Lead\Models\Pipeline;
use Webkul\Lead\Models\Source;
use Webkul\Lead\Models\Stage;
use Webkul\Lead\Models\StageChecklist;
use Webkul\Lead\Models\StageChecklistCompletion;
use Webkul\Lead\Models\Type;
use Webkul\Product\Models\Product;
use Webkul\Quote\Models\Quote;
use Webkul\Quote\Models\QuoteItem;
use Webkul\User\Models\User;

class NexoraDemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds to populate realistic CRM demo data.
     */
    public function run(): void
    {
        $user = User::first();
        if (! $user) {
            $user = User::create([
                'name' => 'Alex Mercer',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
                'status' => 1,
                'role_id' => 1,
                'view_permission' => 'global',
            ]);
        }

        $pipeline = Pipeline::where('is_default', 1)->first() ?? Pipeline::first();
        $stages = Stage::where('lead_pipeline_id', $pipeline->id)->orderBy('sort_order')->get()->keyBy('code');

        $sourceWeb = Source::firstOrCreate(['name' => 'Website']);
        $sourceInbound = Source::firstOrCreate(['name' => 'Inbound Call']);
        $sourceReferral = Source::firstOrCreate(['name' => 'Referral']);

        $typeNew = Type::firstOrCreate(['name' => 'New Business']);
        $typeExisting = Type::firstOrCreate(['name' => 'Existing Business']);

        // 1. Seed Realistic Organizations
        $orgsData = [
            [
                'name' => 'Apex Dynamics Global',
                'address' => [
                    'address' => '500 Howard Street, Suite 400',
                    'city' => 'San Francisco',
                    'state' => 'CA',
                    'country' => 'US',
                    'postcode' => '94105',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Lumina Financial Systems',
                'address' => [
                    'address' => '140 Broadway, 28th Floor',
                    'city' => 'New York',
                    'state' => 'NY',
                    'country' => 'US',
                    'postcode' => '10005',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'CloudScale Technologies',
                'address' => [
                    'address' => '221 Congress Avenue',
                    'city' => 'Austin',
                    'state' => 'TX',
                    'country' => 'US',
                    'postcode' => '78701',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'BioSphere Healthcare Logistics',
                'address' => [
                    'address' => '75 Cambridge Parkway',
                    'city' => 'Cambridge',
                    'state' => 'MA',
                    'country' => 'US',
                    'postcode' => '02142',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Quantum Robotics Corp',
                'address' => [
                    'address' => '1201 Third Avenue, Suite 1800',
                    'city' => 'Seattle',
                    'state' => 'WA',
                    'country' => 'US',
                    'postcode' => '98101',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Nexus Cyber Innovations',
                'address' => [
                    'address' => '300 North LaSalle Street',
                    'city' => 'Chicago',
                    'state' => 'IL',
                    'country' => 'US',
                    'postcode' => '60654',
                ],
                'user_id' => $user->id,
            ],
        ];

        $organizations = [];
        foreach ($orgsData as $data) {
            $organizations[$data['name']] = Organization::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        // 2. Seed Realistic Contacts (Persons)
        $personsData = [
            [
                'name' => 'Eleanor Vance',
                'job_title' => 'VP of Strategic Partnerships',
                'emails' => [['value' => 'eleanor.vance@apexdynamics.io', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (415) 890-2341', 'label' => 'work']],
                'organization_id' => $organizations['Apex Dynamics Global']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Marcus Brody',
                'job_title' => 'Chief Technology Officer',
                'emails' => [['value' => 'marcus.brody@cloudscale.net', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (512) 761-9023', 'label' => 'work']],
                'organization_id' => $organizations['CloudScale Technologies']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Sarah Jenkins',
                'job_title' => 'Head of Global Operations',
                'emails' => [['value' => 's.jenkins@lumina-fin.com', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (212) 555-0198', 'label' => 'work']],
                'organization_id' => $organizations['Lumina Financial Systems']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Dr. Aris Thorne',
                'job_title' => 'Director of Medical IT Infrastructure',
                'emails' => [['value' => 'aris.thorne@biosphere-health.org', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (617) 440-8812', 'label' => 'work']],
                'organization_id' => $organizations['BioSphere Healthcare Logistics']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Elena Rostova',
                'job_title' => 'Senior Procurement Specialist',
                'emails' => [['value' => 'elena.rostova@quantumrobotics.ai', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (206) 912-4450', 'label' => 'work']],
                'organization_id' => $organizations['Quantum Robotics Corp']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'David Vance',
                'job_title' => 'Managing Director',
                'emails' => [['value' => 'david.vance@nexuscyber.com', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (312) 770-3329', 'label' => 'work']],
                'organization_id' => $organizations['Nexus Cyber Innovations']->id,
                'user_id' => $user->id,
            ],
        ];

        $persons = [];
        foreach ($personsData as $data) {
            $persons[$data['name']] = Person::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        // 3. Seed Enterprise Products
        $productsData = [
            [
                'name' => 'Nexora Enterprise Platform Core (Annual)',
                'sku' => 'NX-ENT-CORE',
                'description' => 'Unlimited pipeline stages, visual workflow automation, granular RBAC permissions, and system telemetry.',
                'price' => 12000.00,
                'quantity' => 100,
            ],
            [
                'name' => 'AI Sales Copilot & Deal Intelligence Suite',
                'sku' => 'NX-AI-COPILOT',
                'description' => 'Autonomous lead scoring, meeting action items extractor, predictive win velocity, and generative email assistant.',
                'price' => 3500.00,
                'quantity' => 250,
            ],
            [
                'name' => 'Visual Workflow Automation Engine Pack',
                'sku' => 'NX-WFL-AUTO',
                'description' => 'Drag-and-drop trigger-conditional canvas with webhook dispatchers, delay queues, and multi-rep assignment.',
                'price' => 1800.00,
                'quantity' => 150,
            ],
            [
                'name' => '24/7 Dedicated Mission-Critical SLA Support',
                'sku' => 'NX-SLA-PREMIUM',
                'description' => '15-minute response SLA, dedicated solutions engineer, quarterly pipeline audit, and custom migrations.',
                'price' => 6000.00,
                'quantity' => 50,
            ],
            [
                'name' => 'Two-Way Meeting Scheduler & Omnichannel VoIP',
                'sku' => 'NX-COMM-VOIP',
                'description' => 'Direct public rep booking links (/book/rep), calendar two-way sync, in-browser WebRTC click-to-dial.',
                'price' => 2200.00,
                'quantity' => 300,
            ],
        ];

        $products = [];
        foreach ($productsData as $data) {
            $products[$data['sku']] = Product::updateOrCreate(
                ['sku' => $data['sku']],
                $data
            );
        }

        // 4. Seed Diverse Leads / Deals across Pipeline Stages
        $stageNew = $stages->get('new');
        $stageFollowUp = $stages->get('follow-up');
        $stageProspect = $stages->get('prospect');
        $stageNegotiation = $stages->get('negotiation');
        $stageWon = $stages->get('won');
        $stageLost = $stages->get('lost');

        $leadsData = [
            [
                'title' => 'Apex Dynamics - Enterprise Platform Migration',
                'description' => 'Migrating from legacy Salesforce instance to Nexora CRM self-hosted enterprise deployment for 120 sales reps.',
                'lead_value' => 48500.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(45),
                'user_id' => $user->id,
                'person_id' => $persons['Eleanor Vance']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageNew->id,
                'stage_updated_at' => Carbon::now()->subDays(1), // Healthy in New
            ],
            [
                'title' => 'CloudScale Technologies - Enterprise SaaS & AI Copilot',
                'description' => 'Interested in AI Copilot deal scoring and automated call transcript action item extraction.',
                'lead_value' => 24000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(28),
                'user_id' => $user->id,
                'person_id' => $persons['Marcus Brody']->id,
                'lead_source_id' => $sourceInbound->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageFollowUp->id,
                'stage_updated_at' => Carbon::now()->subDays(9), // ROTTEN! Threshold is 5 days -> will show pulsing rotten indicator!
            ],
            [
                'title' => 'Lumina Financial - Compliance Suite Modernization',
                'description' => 'Requirements include multi-tenant security, custom EAV fields, and immutable audit logging for SEC compliance.',
                'lead_value' => 65000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(35),
                'user_id' => $user->id,
                'person_id' => $persons['Sarah Jenkins']->id,
                'lead_source_id' => $sourceReferral->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageProspect->id,
                'stage_updated_at' => Carbon::now()->subDays(2), // Healthy in Prospect
            ],
            [
                'title' => 'BioSphere Healthcare - Multi-Facility Workflow Deployment',
                'description' => 'Deploying Nexora across 14 hospital logistic branches with automated supplier notification pipelines.',
                'lead_value' => 92000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(14),
                'user_id' => $user->id,
                'person_id' => $persons['Dr. Aris Thorne']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeExisting->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageNegotiation->id,
                'stage_updated_at' => Carbon::now()->subDays(20), // ROTTEN! Threshold is 14 days -> will show pulsing rotten indicator!
            ],
            [
                'title' => 'Quantum Robotics - Sales Operations Automation Pack',
                'description' => 'Automated lead assignment via round-robin and CPQ quotation generator with PDF exports.',
                'lead_value' => 38000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(20),
                'user_id' => $user->id,
                'person_id' => $persons['Elena Rostova']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageNegotiation->id,
                'stage_updated_at' => Carbon::now()->subDays(3), // Healthy in Negotiation
            ],
            [
                'title' => 'Nexus Cyber Innovations - Multi-Year SLA & Platform',
                'description' => 'Contract signed and fully closed. 3-year enterprise license with dedicated solutions engineer.',
                'lead_value' => 78000.00,
                'status' => 1, // Won
                'closed_at' => Carbon::now()->subDays(6),
                'expected_close_date' => Carbon::now()->subDays(6),
                'user_id' => $user->id,
                'person_id' => $persons['David Vance']->id,
                'lead_source_id' => $sourceReferral->id,
                'lead_type_id' => $typeExisting->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageWon->id,
                'stage_updated_at' => Carbon::now()->subDays(6),
            ],
            [
                'title' => 'AeroGlobal Defense - Trial Run Evaluation',
                'description' => 'Pilot project concluded; client deferred budget to next fiscal budget cycle.',
                'lead_value' => 18500.00,
                'status' => 0, // Lost
                'lost_reason' => 'Budget deferred to next fiscal budget year.',
                'closed_at' => Carbon::now()->subDays(10),
                'expected_close_date' => Carbon::now()->subDays(10),
                'user_id' => $user->id,
                'person_id' => $persons['Marcus Brody']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageLost->id,
                'stage_updated_at' => Carbon::now()->subDays(10),
            ],
        ];

        $createdLeads = [];
        foreach ($leadsData as $data) {
            $createdLeads[] = Lead::updateOrCreate(
                ['title' => $data['title']],
                $data
            );
        }

        // 5. Seed Stage Playbook Checklist Completions to show realistic progress pills!
        $allChecklists = StageChecklist::all()->groupBy('lead_pipeline_stage_id');

        foreach ($createdLeads as $lead) {
            $stageId = $lead->lead_pipeline_stage_id;
            if (isset($allChecklists[$stageId])) {
                $stageChecklists = $allChecklists[$stageId];
                // For BioSphere Healthcare (Negotiation), complete all 3 checklists (3/3)
                if (str_contains($lead->title, 'BioSphere')) {
                    foreach ($stageChecklists as $chk) {
                        StageChecklistCompletion::updateOrCreate([
                            'lead_id' => $lead->id,
                            'lead_stage_checklist_id' => $chk->id,
                        ], [
                            'is_completed' => true,
                            'completed_by_user_id' => $user->id,
                            'completed_at' => Carbon::now()->subDays(2),
                        ]);
                    }
                }
                // For Lumina Financial (Prospect), complete 2 out of 3 checklists
                elseif (str_contains($lead->title, 'Lumina')) {
                    foreach ($stageChecklists->take(2) as $chk) {
                        StageChecklistCompletion::updateOrCreate([
                            'lead_id' => $lead->id,
                            'lead_stage_checklist_id' => $chk->id,
                        ], [
                            'is_completed' => true,
                            'completed_by_user_id' => $user->id,
                            'completed_at' => Carbon::now()->subDays(1),
                        ]);
                    }
                }
                // For Apex Dynamics (New), complete 1 checklist
                elseif (str_contains($lead->title, 'Apex Dynamics')) {
                    if ($firstChk = $stageChecklists->first()) {
                        StageChecklistCompletion::updateOrCreate([
                            'lead_id' => $lead->id,
                            'lead_stage_checklist_id' => $firstChk->id,
                        ], [
                            'is_completed' => true,
                            'completed_by_user_id' => $user->id,
                            'completed_at' => Carbon::now()->subHours(8),
                        ]);
                    }
                }
            }
        }

        // 6. Seed Realistic Activities (Meetings, Calls, Notes)
        $activitiesData = [
            [
                'title' => 'Executive Architecture & Security Discovery',
                'type' => 'meeting',
                'comment' => 'Deep dive session with Marcus Brody on multi-region failover and GDPR data export compliance.',
                'schedule_from' => Carbon::now()->addDays(2)->setHour(14)->setMinute(0),
                'schedule_to' => Carbon::now()->addDays(2)->setHour(15)->setMinute(0),
                'is_done' => 0,
                'user_id' => $user->id,
                'lead_id' => $createdLeads[1]->id, // CloudScale
            ],
            [
                'title' => 'Commercial Pricing & Discount Negotiation Call',
                'type' => 'call',
                'comment' => 'Reviewed tiered volume discounts with Dr. Aris Thorne; approved 10% multi-site platform rebate.',
                'schedule_from' => Carbon::now()->subDays(2)->setHour(10)->setMinute(30),
                'schedule_to' => Carbon::now()->subDays(2)->setHour(11)->setMinute(15),
                'is_done' => 1,
                'user_id' => $user->id,
                'lead_id' => $createdLeads[3]->id, // BioSphere
            ],
            [
                'title' => 'Solution Demonstration: Visual Workflow Automation Canvas',
                'type' => 'meeting',
                'comment' => 'Walked Eleanor Vance and executive committee through the node-based workflow builder.',
                'schedule_from' => Carbon::now()->subDays(4)->setHour(16)->setMinute(0),
                'schedule_to' => Carbon::now()->subDays(4)->setHour(17)->setMinute(0),
                'is_done' => 1,
                'user_id' => $user->id,
                'lead_id' => $createdLeads[0]->id, // Apex Dynamics
            ],
        ];

        foreach ($activitiesData as $actData) {
            $leadId = $actData['lead_id'];
            unset($actData['lead_id']);

            $activity = Activity::firstOrCreate(['title' => $actData['title']], $actData);
            $activity->leads()->syncWithoutDetaching([$leadId]);
            $activity->participants()->firstOrCreate(['user_id' => $user->id]);
        }

        // 7. Seed Commercial Quotations with Line Items
        $quote1 = Quote::updateOrCreate([
            'subject' => 'Enterprise CRM Migration Proposal - Apex Dynamics',
        ], [
            'description' => 'Annual enterprise license, AI Copilot add-on, and mission-critical 24/7 SLA.',
            'billing_address' => [
                'address' => '500 Howard Street, Suite 400',
                'city' => 'San Francisco',
                'state' => 'CA',
                'country' => 'US',
                'postcode' => '94105',
            ],
            'shipping_address' => [
                'address' => '500 Howard Street, Suite 400',
                'city' => 'San Francisco',
                'state' => 'CA',
                'country' => 'US',
                'postcode' => '94105',
            ],
            'discount_percent' => 0,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'adjustment_amount' => 0,
            'sub_total' => 21500.00,
            'grand_total' => 21500.00,
            'expired_at' => Carbon::now()->addDays(30),
            'user_id' => $user->id,
            'person_id' => $persons['Eleanor Vance']->id,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote1->id,
            'product_id' => $products['NX-ENT-CORE']->id,
        ], [
            'sku' => 'NX-ENT-CORE',
            'name' => 'Nexora Enterprise Platform Core (Annual)',
            'quantity' => 1,
            'price' => 12000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 12000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote1->id,
            'product_id' => $products['NX-AI-COPILOT']->id,
        ], [
            'sku' => 'NX-AI-COPILOT',
            'name' => 'AI Sales Copilot & Deal Intelligence Suite',
            'quantity' => 1,
            'price' => 3500.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 3500.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote1->id,
            'product_id' => $products['NX-SLA-PREMIUM']->id,
        ], [
            'sku' => 'NX-SLA-PREMIUM',
            'name' => '24/7 Dedicated Mission-Critical SLA Support',
            'quantity' => 1,
            'price' => 6000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 6000.00,
        ]);
    }
}
