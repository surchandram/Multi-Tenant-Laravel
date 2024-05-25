<?php

namespace SAAS\Domain\Users\ViewModels\Admin;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Users\DataTransferObjects\PermissionData;
use SAAS\Domain\Users\Models\Permission;

class UpsertPermissionViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Permission $permission = null,
    ) {
    }

    public function permissions()
    {
        return PermissionData::collection(
            Permission::get()
        );
    }

    public function types()
    {
        return config('laravel-roles.permitables', []);
    }

    public function permission()
    {
        if (! $this->permission) {
            return [];
        }

        return PermissionData::fromModel($this->permission);
    }
}
