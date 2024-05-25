<?php

namespace SAAS\Domain\Companies\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use SAAS\Domain\Companies\Actions\RunAppSetupTasksAction;
use SAAS\Domain\Companies\Events\CompanyCreated;

class PresetCompanyApps implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(CompanyCreated $event)
    {
        $company = $event->company;

        $company->apps->each(fn ($app) => RunAppSetupTasksAction::execute($app, $company));
    }
}
