<?php

namespace SAAS\App\UserInvitations\Handlers\Contracts;

use SAAS\Domain\Users\Models\User;
use SAAS\Domain\Users\Models\UserInvitation;

interface InvitationHandlerFactory
{
    public function __construct(User $user, UserInvitation $invitation);

    /**
     * Handles invitation setup logic.
     *
     * @return mixed
     */
    public function handle();
}
