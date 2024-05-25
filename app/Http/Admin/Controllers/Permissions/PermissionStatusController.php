<?php

namespace SAAS\Http\Admin\Controllers\Permissions;

use SAAS\Domain\Users\Models\Permission;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class PermissionStatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Users\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Permission $permission)
    {
        $permission->usable = (bool)!$permission->usable;
        $permission->save();

        return back()->withSuccess(
            __('\':name\' permission status updated successfully.', ['name' => $permission->name])
        );
    }
}
