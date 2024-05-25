<?php

namespace SAAS\Domain\Restore\Listeners\Projects\Approved;

use SAAS\Domain\Restore\Events\Projects\ProjectApprovedEvent;
use SAAS\Domain\Restore\Jobs\Project\SendProjectApprovedNotificationsJob;

class SendApprovedNotificationsListener
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
        SendProjectApprovedNotificationsJob::dispatch($event->project, $event->company);
    }
}
