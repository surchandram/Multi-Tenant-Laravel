<?php

namespace SAAS\Http\Admin\Controllers\Roles;

use SAAS\Domain\Users\Models\Role;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class RoleStatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \SAAS\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Role $role)
    {
        $role->usable = (bool)!$role->usable;
        $role->save();

        return back()->withSuccess(
            __('\':name\' role status updated successfully.', ['name' => $role->name])
        );
    }
}
