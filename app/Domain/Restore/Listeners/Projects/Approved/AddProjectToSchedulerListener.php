<?php

namespace SAAS\Domain\Restore\Listeners\Projects\Approved;

use SAAS\Domain\Restore\Events\Projects\ProjectApprovedEvent;

class AddProjectToSchedulerListener
{
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
    public function handle(ProjectApprovedEvent $event)
    {
        //
    }
}
