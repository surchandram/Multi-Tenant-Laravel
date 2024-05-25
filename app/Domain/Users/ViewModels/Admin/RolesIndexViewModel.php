<?php

namespace SAAS\Domain\Users\ViewModels\Admin;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Users\DataTransferObjects\RoleData;
use SAAS\Domain\Users\Models\Role;

class RolesIndexViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Request $request = null,
    ) {
    }

    public function roles()
    {
        return RoleData::collection(
            Role::with(['parent'])
                ->withCount(['parent', 'users', 'children', 'permissions'])
                ->withDepth()
                ->search($this->request->name)
                ->whereIn('type', array_keys(config('laravel-roles.permitables')))
                ->whereNull('roleable_type')
                ->get()
                ->toFlatTree()
        );
    }

    public function meta()
    {
        return [
            'per_page' => 15,
        ];
    }

    public function filters()
    {
        return [];
    }
}
