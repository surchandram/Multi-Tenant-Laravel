<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Users\Models\Role;

class CompanyRoleStatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Company $company, Role $role)
    {
        abort_if(Gate::denies('assign company roles', $company), 404);

        if ($role->slug === $company->teamAdminRoleSlug()) {
            return back()->withError(
                __('You cannot disable the Admin role of company.')
            );
        }

        $role->usable = (bool) ! $role->usable;
        $role->save();

        $company->flushCache();

        return back()->withSuccess(
            __('The \':name\' role status updated successfully.', ['name' => $role->name])
        );
    }
}
