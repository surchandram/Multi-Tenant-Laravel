<?php

namespace SAAS\Domain\Users\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SAAS\Domain\Users\Models\UserInvitation;

class SendUserInvitation
{
    use Dispatchable, SerializesModels;

    /**
     * UserInvitation model instance.
     *
     * @var \SAAS\Domain\Users\Models\UserInvitation
     */
    public $invitation;

    /**
     * Create a new event instance.
     *
     * @param  \SAAS\Domain\Users\Models\UserInvitation  $invitation
     * @return void
     */
    public function __construct(UserInvitation $invitation)
    {
        $this->invitation = $invitation;
    }
}
