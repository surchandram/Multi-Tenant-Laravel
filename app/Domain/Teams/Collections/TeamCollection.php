<?php

namespace SAAS\Domain\Teams\Collections;

use Illuminate\Database\Eloquent\Collection;
use SAAS\Domain\Users\Models\User;

class TeamCollection extends Collection
{
    /**
     * Add 'current_user_roles' field to collection.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @return \Illuminate\Support\Collection
     */
    public function withCurrentUserRoles(?User $user)
    {
        return $this->map(function ($team) {
            $roles = $team->users->first()->roles->where(
                fn ($role) => $role->pivot->permitable_id === $team->id
            );

            $team->current_user_roles = $roles;

            return $team;
        });
    }
}
