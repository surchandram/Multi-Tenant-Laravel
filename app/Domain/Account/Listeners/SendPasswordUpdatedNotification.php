<?php

namespace SAAS\Domain\Account\Listeners;

use SAAS\Domain\Account\Events\PasswordUpdated;
use SAAS\Domain\Account\Notifications\PasswordUpdatedNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordUpdatedNotification
{
    /**
     * Handle the event.
     *
     * @param  \SAAS\Domain\Account\Events\PasswordUpdated  $event
     * @return void
     */
    public function handle(PasswordUpdated $event)
    {
        $user = $event->user;

        $user->notify(new PasswordUpdatedNotification());
    }
}
