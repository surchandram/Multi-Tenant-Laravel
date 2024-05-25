<?php

namespace SAAS\Domain\Account\Listeners;

use SAAS\Domain\Account\Events\AccountRestored;
use SAAS\Domain\Account\Notifications\AccountRestoredNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAccountRestoredNotification
{
    /**
     * Handle the event.
     *
     * @param  AccountRestored  $event
     * @return void
     */
    public function handle(AccountRestored $event)
    {
        $user = $event->user;

        $user->notify(new AccountRestoredNotification());
    }
}
