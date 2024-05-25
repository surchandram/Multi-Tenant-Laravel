<?php

namespace SAAS\Domain\Restore\Jobs\Project;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Restore\Actions\SendProjectApprovedNotificationsAction;
use SAAS\Domain\Restore\Models\Project;

class SendProjectApprovedNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public readonly Project $project,
        public readonly Company $company,
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SendProjectApprovedNotificationsAction::execute($this->project, $this->company);
    }
}
