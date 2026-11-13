<?php

namespace Webkul\Admin\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'lead_value' => $this->lead_value,
            'formatted_lead_value' => core()->formatBasePrice($this->lead_value),
            'is_user_defined' => $this->is_user_defined,
            'sort_order' => $this->sort_order,
            'rotten_days' => $this->rotten_days,
            'checklists' => $this->checklists ? $this->checklists->map(fn ($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'is_required' => $item->is_required,
                'sort_order' => $item->sort_order,
            ]) : [],
            'lead_pipeline_id' => $this->lead_pipeline_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
