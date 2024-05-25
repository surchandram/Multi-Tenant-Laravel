<?php

namespace SAAS\Domain\Restore\Invitations;

use SAAS\App\UserInvitations\Handlers\Contracts\InvitationHandlerFactory;
use SAAS\App\UserInvitations\Handlers\InvitationHandlerAbstract;

class CustomerInvitationHandler extends InvitationHandlerAbstract implements InvitationHandlerFactory
{
    public function handle()
    {
        $this->invitation->markAccepted();

        return true;
    }
}
