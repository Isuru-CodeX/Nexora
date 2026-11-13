<?php

namespace Webkul\Lead\Repositories;

use Webkul\Core\Eloquent\Repository;

class StageChecklistRepository extends Repository
{
    /**
     * Specify Model class name.
     */
    public function model(): string
    {
        return 'Webkul\Lead\Contracts\StageChecklist';
    }
}
