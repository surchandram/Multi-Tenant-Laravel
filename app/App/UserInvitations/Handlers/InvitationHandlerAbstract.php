<?php

namespace SAAS\App\UserInvitations\Handlers;

use Illuminate\Database\Eloquent\Model;
use SAAS\App\Providers\RouteServiceProvider;
use SAAS\App\UserInvitations\Handlers\Contracts\InvitationHandlerFactory;
use SAAS\Domain\Users\Models\User;
use SAAS\Domain\Users\Models\UserInvitation;

abstract class InvitationHandlerAbstract implements InvitationHandlerFactory
{
    public User $user;

    public UserInvitation $invitation;

    /**
     * InvitationHandlerAbstract Constructor.
     *
     * @return void
     */
    public function __construct(User $user, UserInvitation $invitation)
    {
        $this->user = $user;
        $this->invitation = $invitation;
    }

    public function redirectTo()
    {
        return property_exists($this, 'redirectTo') ? route($this->redirectTo) : RouteServiceProvider::HOME;
    }

    protected function getInvitationRoleExpiryTimestamp()
    {
        return $this->invitation->role_expires_at;
    }

    protected function resolvePermitableIdFromRole(Model $owner)
    {
        $roleable = $this->invitation->role->roleable;

        if (! ($class = config('laravel-roles.models.'.$this->invitation->role->type))) {
            $this->cannotAssignInvalidRole();
        }

        if (! ($owner instanceof $class)) {
            $this->cannotAssignInvalidRole();
        }

        if (empty($roleable)) {
            return $owner->id;
        }

        if ($owner->is($roleable)) {
            return null;
        }

        $this->cannotAssignInvalidRole();
    }

    protected function cannotAssignInvalidRole()
    {
        return throw new \Exception("Cannot assign [{$this->invitation->role->name}] to user since it does not exist. Make sure you the role exists before assigning it.");
    }
}
