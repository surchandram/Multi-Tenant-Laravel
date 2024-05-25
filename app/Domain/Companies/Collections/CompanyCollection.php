<?php

namespace SAAS\Domain\Companies\Collections;

use Illuminate\Database\Eloquent\Collection;
use SAAS\Domain\Users\Models\User;

class CompanyCollection extends Collection
{
    /**
     * Add 'current_user_roles' field to collection.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @return \Illuminate\Support\Collection
     */
    public function withCurrentUserRoles(?User $user)
    {
        return $this->map(function ($company) {
            $roles = $company->users->first()->roles->where(
                fn ($role) => $role->pivot->permitable_id === $company->id
            );

            $company->current_user_roles = $roles;

            return $company;
        });
    }
}
