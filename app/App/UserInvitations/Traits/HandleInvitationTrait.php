<?php

namespace SAAS\App\UserInvitations\Traits;

use Illuminate\Http\Request;
use SAAS\App\UserInvitations\Handlers\Contracts\InvitationHandlerFactory;
use SAAS\Domain\Users\Models\User;
use SAAS\Domain\Users\Models\UserInvitation;

trait HandleInvitationTrait
{
    public function handleInvitationFromSession(User $user, Request $request)
    {
        $invite = session()->get('invitation_data');

        $invitation = UserInvitation::isStillValid()
            ->where('email', $request->input('email'))
            ->where('id', $invite['id'])
            ->where('type', $invite['type'])
            ->where('identifier', $invite['identifier'])
            ->first();

        if ($this->isRoleBasedInvitation($invitation)) {
            if ($this->isRecognizedInvitationType($invitation)) {
                $handler = $this->callInvitationHandler($user, $invitation);

                $this->acceptInvitation($invitation);
                $request->session()->forget('invitation_data');

                return $handler;
            }
        }
        $this->acceptInvitation($invitation);
        $request->session()->forget('invitation_data');
    }

    public function callInvitationHandler(User $user, UserInvitation $invitation)
    {
        $handlerClass = $this->resolveHandlerClass($invitation->type);

        if (empty($handlerClass) || ! class_exists($handlerClass)) {
            throw new \Exception("No valid class found for [{$invitation->type}]. Make sure the class is registered in [config/saas.php] under [invitations.handlers].");
        }

        $handler = new $handlerClass($user, $invitation);

        if (! $handler instanceof InvitationHandlerFactory) {
            throw new \Exception("Invitation Handler must be an instance of [SAAS\App\UserInvitations\Handlers\Contracts\InvitationHandlerFactory]");
        }

        return $handler->handle();
    }

    protected function resolveHandlerClass(string $type)
    {
        return config('saas.invitations.handlers.'.$type);
    }

    protected function acceptInvitation(UserInvitation $invitation)
    {
        return $invitation->markAccepted();
    }

    protected function getInvitationRoleExpiryTimestamp($invitation)
    {
        return $invitation->role_expires_at;
    }

    protected function isRecognizedInvitationType($invitation)
    {
        return in_array($invitation->type, array_keys(config('saas.invitations.types')));
    }

    protected function isRoleBasedInvitation($invitation)
    {
        return $invitation->role_id !== null;
    }
}
