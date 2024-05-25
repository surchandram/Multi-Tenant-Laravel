<?php

namespace SAAS\Domain\Users\ViewModels\Admin;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Users\DataTransferObjects\PermissionData;
use SAAS\Domain\Users\Models\Permission;

class PermissionsIndexViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Request $request = null,
    ) {
    }

    public function permissions()
    {
        return PermissionData::collection(
            Permission::search($this->request->name)->latest()->paginate()
        );
    }

    public function filters()
    {
        return [];
    }
}
