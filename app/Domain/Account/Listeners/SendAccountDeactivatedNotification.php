<?php

namespace SAAS\Domain\Account\Listeners;

use SAAS\Domain\Account\Events\AccountDeactivated;
use SAAS\Domain\Account\Notifications\AccountDeactivatedNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAccountDeactivatedNotification
{
    /**
     * Handle the event.
     *
     * @param  AccountDeactivated  $event
     * @return void
     */
    public function handle(AccountDeactivated $event)
    {
        $user = $event->user;

        $user->notify(new AccountDeactivatedNotification());
    }
}
