<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SAAS\App\Controllers\Controller;
use SAAS\App\Support\Roles;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Users\Models\Role;
use SAAS\Http\Companies\Requests\CompanyRoleStoreRequest;
use SAAS\Http\Companies\Requests\CompanyRoleUpdateRequest;

class CompanyRoleController extends Controller
{
    /**
     * CompanyRoleController constructor.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(['auth']);
        $this->middleware(['in_team:'.$request->company]);
        $this->middleware(['permission:assign company roles,company:'.$request->company]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        $company->loadMissing([
            'roles' => function ($query) {
                $query->orderByDesc('created_at');
            },
            'roles.users' => function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            },
        ]);

        $companyAdmin = Role::whereSlug(Roles::$roleWhenCreatingCompany)->with([
            'users' => function ($query) use ($company) {
                $query->where('permitable_id', $company->getKey())->whereNull('expires_at')->orWhere('expires_at', '>', now());
            },
        ])->first();
        $company->roles->prepend($companyAdmin);

        return view('companies.roles.index', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        return view('companies.roles.create', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRoleStoreRequest $request, Company $company)
    {
        $role = new Role();
        $role->fill($request->only('name', 'description', 'type'));
        $role->slug = Str::slug($role->name.' '.$company->getOriginal('id'));
        $role->usable = $request->input('usable', false);

        if (isset($request->parent_id)) {
            $role->parent()->associate(Role::find($request->parent_id));
        }

        $company->roles()->save($role);

        $role->addPermissions($request->permissions);

        $company->flushCache();

        return redirect()->back()
            ->withSuccess(__('app.role.created', ['name' => $role->name]));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, Role $role)
    {
        $role->load(['permissions']);

        return view('companies.roles.edit', compact('company', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRoleUpdateRequest $request, Company $company, Role $role)
    {
        $role->fill($request->only('name', 'description'));

        // prevent company Admin role from being disabled
        if ($role->slug !== $company->teamAdminRoleSlug()) {
            $role->usable = $request->input('usable', false);
        }

        if (isset($request->parent_id)) {
            $role->parent()->associate(Role::find($request->parent_id));
        }

        $role->save();

        // prevent detaching of permissions from Admin roles
        if ($role->slug === $company->teamAdminRoleSlug()) {
            $role->addPermissions($request->permissions);
        } else {
            $role->syncPermissions($request->permissions);
        }

        $company->flushCache();

        return back()->withSuccess(__('app.role.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Role $role)
    {
        if ($role->users->count()) {
            return back()->withError(
                __('You cannot delete the \':name\' role, since it has users assigned to it.', ['name' => $role->name])
            )->withInfo(
                __('You can disable role, to prevent users from using it.')
            );
        }

        if ($role->slug === $company->teamAdminRoleSlug()) {
            return back()->withError(
                __('You cannot delete the Admin role of company.')
            );
        }

        try {
            $role->delete();
        } catch (\Exception $e) {
            return back()->withError(
                __('Some error occurred when deleting role \':name\'.', ['name' => $role->name])
            );
        }

        $company->flushCache();

        return back()->withSuccess(
            __('Role \':name\' deleted successfully.', ['name' => $role->name])
        );
    }
}
