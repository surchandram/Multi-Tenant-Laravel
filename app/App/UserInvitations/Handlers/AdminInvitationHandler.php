<?php

namespace SAAS\App\UserInvitations\Handlers;

use SAAS\App\UserInvitations\Handlers\Contracts\InvitationHandlerFactory;

class AdminInvitationHandler extends InvitationHandlerAbstract implements InvitationHandlerFactory
{
    public $redirectTo = 'admin.dashboard';

    public function handle()
    {
        if ($this->invitation->role->type === 'admin') {
            $this->user->assignRole(
                $this->invitation->role,
                $this->getInvitationRoleExpiryTimestamp()
            );
        }
    }
}
