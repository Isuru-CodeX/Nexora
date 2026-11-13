<?php

namespace Webkul\Lead\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Lead\Contracts\Stage as StageContract;

class Stage extends Model implements StageContract
{
    public $timestamps = false;

    protected $table = 'lead_pipeline_stages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'probability',
        'sort_order',
        'rotten_days',
        'lead_pipeline_id',
    ];

    /**
     * Get the pipeline that owns the pipeline stage.
     */
    public function pipeline()
    {
        return $this->belongsTo(PipelineProxy::modelClass(), 'lead_pipeline_id');
    }

    /**
     * Get the leads.
     */
    public function leads()
    {
        return $this->hasMany(LeadProxy::modelClass(), 'lead_pipeline_stage_id');
    }

    /**
     * Get the checklists for the stage.
     */
    public function checklists()
    {
        return $this->hasMany(StageChecklistProxy::modelClass(), 'lead_pipeline_stage_id')->orderBy('sort_order');
    }
}
