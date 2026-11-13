<?php

namespace Webkul\Lead\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Lead\Contracts\StageChecklistCompletion as StageChecklistCompletionContract;
use Webkul\User\Models\UserProxy;

class StageChecklistCompletion extends Model implements StageChecklistCompletionContract
{
    protected $table = 'lead_stage_checklist_completions';

    protected $fillable = [
        'lead_id',
        'lead_stage_checklist_id',
        'is_completed',
        'completed_by_user_id',
        'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the lead that owns this completion.
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(LeadProxy::modelClass(), 'lead_id');
    }

    /**
     * Get the checklist item.
     */
    public function checklist(): BelongsTo
    {
        return $this->belongsTo(StageChecklistProxy::modelClass(), 'lead_stage_checklist_id');
    }

    /**
     * Get the user who completed the checklist item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserProxy::modelClass(), 'completed_by_user_id');
    }
}
