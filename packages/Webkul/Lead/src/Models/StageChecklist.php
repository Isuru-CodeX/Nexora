<?php

namespace Webkul\Lead\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\Lead\Contracts\StageChecklist as StageChecklistContract;

class StageChecklist extends Model implements StageChecklistContract
{
    protected $table = 'lead_stage_checklists';

    protected $fillable = [
        'lead_pipeline_stage_id',
        'name',
        'description',
        'is_required',
        'sort_order',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the stage that owns the checklist item.
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(StageProxy::modelClass(), 'lead_pipeline_stage_id');
    }

    /**
     * Get the completions for this checklist item across leads.
     */
    public function completions(): HasMany
    {
        return $this->hasMany(StageChecklistCompletionProxy::modelClass(), 'lead_stage_checklist_id');
    }
}
