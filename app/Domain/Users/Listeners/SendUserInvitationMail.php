<?php

namespace SAAS\Domain\Users\Listeners;

use Illuminate\Support\Facades\Mail;
use SAAS\Domain\Users\Events\SendUserInvitation;
use SAAS\Domain\Users\Mails\UserInvitationMail;

class SendUserInvitationMail
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(SendUserInvitation $event)
    {
        if ($event->invitation->hasCustomMailClass()) {
            Mail::to($event->invitation->email)->queue($event->invitation->resolvedMailClass());
        } else {
            Mail::to($event->invitation->email)->send(new UserInvitationMail($event->invitation));
        }
    }
}
