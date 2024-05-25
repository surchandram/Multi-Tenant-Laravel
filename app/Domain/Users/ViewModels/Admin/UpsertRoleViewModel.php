<?php

namespace SAAS\Domain\Users\ViewModels\Admin;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Users\DataTransferObjects\PermissionData;
use SAAS\Domain\Users\DataTransferObjects\RoleData;
use SAAS\Domain\Users\Models\Permission;
use SAAS\Domain\Users\Models\Role;

class UpsertRoleViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Role $role = null,
    ) {
        if ($this->role) {
            $this->role->loadMissing([
                'parent',
                'permissions',
            ]);
        }
    }

    public function permissions()
    {
        return PermissionData::collection(
            Permission::active()->get()
        );
    }

    public function roles()
    {
        return RoleData::collection(
            Role::with([
                'parent',
            ])->doesntHave('users')->doesntHave('permissions')->get()
        );
    }

    public function types()
    {
        return config('laravel-roles.permitables', []);
    }

    public function role()
    {
        if (! $this->role) {
            return [];
        }

        return RoleData::fromModel($this->role);
    }
}
