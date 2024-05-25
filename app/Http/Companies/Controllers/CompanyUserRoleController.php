<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Users\Models\Role;
use SAAS\Domain\Users\Models\User;
use SAAS\Http\Companies\Requests\CompanyUserRoleUpdateRequest;

class CompanyUserRoleController extends Controller
{
    /**
     * CompanyUserRoleController constructor.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(['auth']);
        $this->middleware(['in_team:'.$request->company]);
        $this->middleware(['permission:assign company roles,company:'.$request->company])->only('edit', 'update');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, User $user)
    {
        $user->loadMissing([
            'roles' => function ($query) use ($company) {
                $query->whereHasMorph('roleable', Company::class, function ($query) use ($company) {
                    $query->where('id', $company->id);
                })->active()->whereNull('expires_at')->orWhere('expires_at', '>', now());
            },
        ]);
        $company->allRoles();

        return view('companies.users.roles.edit', compact('company', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUserRoleUpdateRequest $request, Company $company, User $user)
    {
        if (! $company->users->contains($user)) {
            return back();
        }

        if ($user->isOnlyAdminInCompany($company)) {
            return back()->withError(
                __('You cannot change the role of the only \'Admin\' in the company.')
            );
        }

        // todo: move to action
        $user->loadMissing([
            'roles' => function ($query) use ($company) {
                $query->whereHasMorph('roleable', Company::class, function ($query) use ($company) {
                    $query->where('id', $company->id);
                })->orWherePivot('permitable_id', $company->id)->active()->whereNull('expires_at')->orWhere('expires_at', '>', now());
            },
        ]);

        $oldRole = $user->roles->first();

        if ($oldRole) {
            $revoked = $user->revokeRoles([], $company);

            if (! $revoked) {
                throw new \Exception("Failed revoking role [$oldRole->name] from user.");
            }
        }

        $role = Role::find($request->role_id);

        $user->assignRole($role, null, $company);

        $company->flushCache();

        return redirect()->route('companies.users.index', $company)->withSuccess(
            __('\':name\' has been assigned \':role\' role.', ['name' => $user->name, 'role' => $role->name])
        );
    }
}
