<?php

namespace SAAS\App\UserInvitations\Handlers;

use SAAS\App\Support\Saas;
use SAAS\App\UserInvitations\Handlers\Contracts\InvitationHandlerFactory;

class CompanyUserInvitationHandler extends InvitationHandlerAbstract implements InvitationHandlerFactory
{
    public $redirectTo = 'tenant.switch';

    public function redirectTo()
    {
        return route($this->redirectTo, $this->invitation->roleable);
    }

    public function handle()
    {
        $company = $this->invitation->roleable;
        $class = config('laravel-roles.models.company');

        if ($company instanceof $class) {
            // company user setup
            $company->users()->syncWithoutDetaching($this->user);

            // resolve if shared role
            $permitableId = $this->resolvePermitableIdFromRole($company);

            $this->user->assignRole(
                $this->invitation->role,
                $this->getInvitationRoleExpiryTimestamp(),
                $permitableId ? $company : null
            );

            // assign user to team if 'team_id' present
            if (isset($this->invitation->data['team_id'])) {
                $teamId = $this->invitation->data['team_id'];

                $team = $company->teams()->where('id', $teamId)->first();

                $team->users()->syncWithoutDetaching($this->user);
            }

            // flush cache
            $company->flushCache();
            $this->user->flushCache();

            // set user's tenant
            $storeKey = Saas::getTenantDriverStoreKey();
            $value = $company->{$storeKey};

            $key = tenancy()->store()->getStoreKeyIdentifier();

            $this->user->update([
                $key => $value,
            ]);
        }

        return $this;
    }
}
