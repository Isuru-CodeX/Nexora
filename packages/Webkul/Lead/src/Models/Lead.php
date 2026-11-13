<?php

namespace Webkul\Lead\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\Activity\Models\ActivityProxy;
use Webkul\Activity\Traits\LogsActivity;
use Webkul\Attribute\Traits\CustomAttribute;
use Webkul\Contact\Models\PersonProxy;
use Webkul\Email\Models\EmailProxy;
use Webkul\Lead\Contracts\Lead as LeadContract;
use Webkul\Quote\Models\QuoteProxy;
use Webkul\Tag\Models\TagProxy;
use Webkul\User\Models\UserProxy;

class Lead extends Model implements LeadContract
{
    use CustomAttribute, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'lead_value',
        'status',
        'lost_reason',
        'expected_close_date',
        'closed_at',
        'user_id',
        'person_id',
        'lead_source_id',
        'lead_type_id',
        'lead_pipeline_id',
        'lead_pipeline_stage_id',
        'stage_updated_at',
    ];

    /**
     * Cast the attributes to their respective types.
     *
     * @var array
     */
    protected $casts = [
        'closed_at' => 'datetime:D M d, Y H:i A',
        'expected_close_date' => 'date:D M d, Y',
        'stage_updated_at' => 'datetime',
    ];

    /**
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = [
        'rotten_days',
        'days_in_stage',
        'is_rotten',
        'checklists_summary',
    ];

    /**
     * Get the user that owns the lead.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserProxy::modelClass());
    }

    /**
     * Get the person that owns the lead.
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(PersonProxy::modelClass());
    }

    /**
     * Get the type that owns the lead.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeProxy::modelClass(), 'lead_type_id');
    }

    /**
     * Get the source that owns the lead.
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(SourceProxy::modelClass(), 'lead_source_id');
    }

    /**
     * Get the pipeline that owns the lead.
     */
    public function pipeline(): BelongsTo
    {
        return $this->belongsTo(PipelineProxy::modelClass(), 'lead_pipeline_id');
    }

    /**
     * Get the pipeline stage that owns the lead.
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(StageProxy::modelClass(), 'lead_pipeline_stage_id');
    }

    /**
     * Get the activities.
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(ActivityProxy::modelClass(), 'lead_activities');
    }

    /**
     * Get the products.
     */
    public function products(): HasMany
    {
        return $this->hasMany(ProductProxy::modelClass());
    }

    /**
     * Get the emails.
     */
    public function emails(): HasMany
    {
        return $this->hasMany(EmailProxy::modelClass());
    }

    /**
     * The quotes that belong to the lead.
     */
    public function quotes(): BelongsToMany
    {
        return $this->belongsToMany(QuoteProxy::modelClass(), 'lead_quotes');
    }

    /**
     * The tags that belong to the lead.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(TagProxy::modelClass(), 'lead_tags');
    }

    /**
     * Get the checklist completions for the lead.
     */
    public function checklistCompletions(): HasMany
    {
        return $this->hasMany(StageChecklistCompletionProxy::modelClass(), 'lead_id');
    }

    /**
     * Returns the rotten days.
     * Uses stage-specific rotten_days if configured, otherwise pipeline default.
     * Evaluates time elapsed since stage_updated_at (or created_at).
     */
    public function getRottenDaysAttribute()
    {
        if (! $this->stage) {
            return 0;
        }

        if (in_array($this->stage->code, ['won', 'lost'])) {
            return 0;
        }

        // Use stage-specific rotten days if set, otherwise fallback to pipeline
        $rottenDaysLimit = $this->stage->rotten_days ?? $this->pipeline?->rotten_days;

        if (! $rottenDaysLimit || $rottenDaysLimit <= 0) {
            return 0;
        }

        $stageEntry = $this->stage_updated_at ?? $this->created_at;

        if (! $stageEntry) {
            return 0;
        }

        $daysInStage = $this->days_in_stage;

        if ($daysInStage >= $rottenDaysLimit) {
            return (int) ($daysInStage - $rottenDaysLimit + 1);
        }

        return 0;
    }

    /**
     * Returns total days spent in the current stage.
     */
    public function getDaysInStageAttribute(): int
    {
        $stageEntry = $this->stage_updated_at ?? $this->created_at;

        if (! $stageEntry) {
            return 0;
        }

        return (int) abs(Carbon::now()->diffInDays($stageEntry));
    }

    /**
     * Check if the lead is currently rotten.
     */
    public function getIsRottenAttribute(): bool
    {
        return $this->rotten_days > 0;
    }

    /**
     * Get a summary of checklist progress for the current stage.
     */
    public function getChecklistsSummaryAttribute(): array
    {
        if (! $this->stage) {
            return [
                'total' => 0,
                'completed' => 0,
                'required_total' => 0,
                'required_completed' => 0,
                'percentage' => 100,
                'can_advance' => true,
            ];
        }

        $checklists = $this->stage->checklists;
        $total = $checklists ? $checklists->count() : 0;

        if ($total === 0) {
            return [
                'total' => 0,
                'completed' => 0,
                'required_total' => 0,
                'required_completed' => 0,
                'percentage' => 100,
                'can_advance' => true,
            ];
        }

        $completedIds = $this->checklistCompletions()
            ->where('is_completed', true)
            ->pluck('lead_stage_checklist_id')
            ->toArray();

        $completedCount = 0;
        $requiredTotal = 0;
        $requiredCompleted = 0;

        foreach ($checklists as $item) {
            $isDone = in_array($item->id, $completedIds);

            if ($isDone) {
                $completedCount++;
            }

            if ($item->is_required) {
                $requiredTotal++;

                if ($isDone) {
                    $requiredCompleted++;
                }
            }
        }

        return [
            'total' => $total,
            'completed' => $completedCount,
            'required_total' => $requiredTotal,
            'required_completed' => $requiredCompleted,
            'percentage' => (int) round(($completedCount / $total) * 100),
            'can_advance' => $requiredCompleted === $requiredTotal,
        ];
    }

    /**
     * Check if there are any mandatory checklist items still incomplete in current stage.
     */
    public function hasPendingRequiredChecklists(): bool
    {
        $summary = $this->checklists_summary;

        return ! $summary['can_advance'];
    }
}
