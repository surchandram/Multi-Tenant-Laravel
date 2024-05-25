<?php

namespace SAAS\Domain\Restore\Events\Projects;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Restore\Models\Project;

class ProjectApprovedEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public readonly Project $project,
        public readonly Company $company,
    ) {
    }
}
