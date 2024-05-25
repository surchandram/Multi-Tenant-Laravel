<?php

namespace SAAS\Domain\Companies\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SAAS\Domain\Companies\Actions\RunAppSetupTasksAction;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\Models\CompanyApp;

class SetupApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public readonly CompanyApp $companyApp,
        public readonly Company $company,
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        RunAppSetupTasksAction::execute($this->companyApp, $this->company);
    }
}
