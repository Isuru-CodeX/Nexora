<?php

namespace Webkul\Lead\Repositories;

use Carbon\Carbon;
use Webkul\Core\Eloquent\Repository;
use Webkul\Lead\Contracts\StageChecklistCompletion;

class StageChecklistCompletionRepository extends Repository
{
    /**
     * Specify Model class name.
     */
    public function model(): string
    {
        return 'Webkul\Lead\Contracts\StageChecklistCompletion';
    }

    /**
     * Toggle a checklist completion state for a lead.
     */
    public function toggle(int $leadId, int $checklistId, ?int $userId = null): StageChecklistCompletion
    {
        $completion = $this->findOneWhere([
            'lead_id' => $leadId,
            'lead_stage_checklist_id' => $checklistId,
        ]);

        if ($completion) {
            $newStatus = ! $completion->is_completed;

            $completion->update([
                'is_completed' => $newStatus,
                'completed_by_user_id' => $newStatus ? ($userId ?? auth()->guard('user')->id()) : null,
                'completed_at' => $newStatus ? Carbon::now() : null,
            ]);

            return $completion;
        }

        return $this->create([
            'lead_id' => $leadId,
            'lead_stage_checklist_id' => $checklistId,
            'is_completed' => true,
            'completed_by_user_id' => $userId ?? auth()->guard('user')->id(),
            'completed_at' => Carbon::now(),
        ]);
    }
}
