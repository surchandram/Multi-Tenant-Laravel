<?php

namespace SAAS\App\Support\Traits\Eloquent;

use SAAS\Domain\Users\Models\Role;
use SAAS\Domain\Users\Models\User;

trait CanAssignRoles
{
    /**
     * Boot `CanAssignRoles` trait.
     */
    public static function bootCanAssignRoles()
    {
        //
    }

    /**
     * Assign a role to a user.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  int|\SAAS\Domain\Users\Models\Role  $role
     * @param  \Carbon\Carbon|\DateTimeInterface  $expiresAt
     * @return bool
     */
    public function revokeRole(User $user, $role, $expiresAt = null): bool
    {
        return $user->revokeRoleByGiver($role, $this, $expiresAt);
    }

    /**
     * Assign a role to a user.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Users\Models\Role  $role
     * @param  \Carbon\Carbon|\DateTimeInterface  $expiresAt
     * @return bool
     */
    public function assignRole(User $user, Role $role, $expiresAt = null): bool
    {
        return $user->assignRole($role, $expiresAt, $this);
    }
}
