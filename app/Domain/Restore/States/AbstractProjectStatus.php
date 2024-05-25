<?php

namespace SAAS\Domain\Restore\States;

use SAAS\Domain\Restore\Models\Project;

abstract class AbstractProjectStatus
{
    public function __construct(
        protected Project $project
    ) {
    }

    abstract public function canBeChanged(): bool;
}
