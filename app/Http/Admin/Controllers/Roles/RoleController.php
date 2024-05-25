<?php

namespace SAAS\Http\Admin\Controllers\Roles;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Miracuthbert\LaravelRoles\Http\Requests\RoleStoreRequest;
use Miracuthbert\LaravelRoles\Http\Requests\RoleUpdateRequest;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Users\Actions\UpsertRoleAction;
use SAAS\Domain\Users\DataTransferObjects\RoleData;
use SAAS\Domain\Users\Models\Role;
use SAAS\Domain\Users\ViewModels\Admin\RolesIndexViewModel;
use SAAS\Domain\Users\ViewModels\Admin\UpsertRoleViewModel;

class RoleController extends Controller
{
    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:browse roles']);
        $this->middleware(['permission:create role'])->only('create');
        $this->middleware(['permission:update role'])->only('edit', 'update');
        $this->middleware(['permission:delete role'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new RolesIndexViewModel($request);

        return Inertia::render('admin/views/roles/Index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new UpsertRoleViewModel();

        return Inertia::render('admin/views/roles/Create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \SAAS\Http\Roles\Requests\RoleStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        try {
            $role = UpsertRoleAction::execute(
                RoleData::fromRequest($request)
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return redirect()->route('admin.roles.create')->withErrors([
                'name' => __('Failed creating role.'),
            ])->withError(__('Something went wrong.'));
        }

        return redirect()->route('admin.roles.index')
            ->withSuccess(__('Role \':name\' successfully added.', ['name' => $role->name]));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $model = new UpsertRoleViewModel($role);

        return Inertia::render('admin/views/roles/Edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        try {
            $role = UpsertRoleAction::execute(
                RoleData::fromRequest($request),
                $role
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return redirect()->route('admin.roles.edit', $role)->withErrors([
                'name' => __('Failed updating role.'),
            ])->withError(__('Something went wrong.'));
        }

        return redirect()->route('admin.roles.edit', $role)->withSuccess(__('Role updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        if ($role->users->count()) {
            return back()->withError(
                __('You cannot delete the \':name\' role, since it has users assigned to it.', ['name' => $role->name])
            )->withInfo(
                __('You can disable role, to prevent users from using it.')
            );
        }

        try {
            $role->delete();
        } catch (\Exception $e) {
            return back()->withError(
                __('Some error occurred when deleting role \':name\'.', ['name' => $role->name])
            );
        }

        return back()->withSuccess(
            __('Role \':name\' deleted successfully.', ['name' => $role->name])
        );
    }
}
