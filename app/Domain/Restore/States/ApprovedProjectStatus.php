<?php

namespace SAAS\Domain\Restore\States;

class ApprovedProjectStatus extends AbstractProjectStatus
{
    public function canBeChanged(): bool
    {
        if ($this->project->user_id !== request()->user()) {
            return false;
        }

        return true;
    }
}
