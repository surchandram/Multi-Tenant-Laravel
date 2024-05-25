<?php

namespace SAAS\Http\Admin\Controllers\Permissions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Users\Actions\DestroyPermissionAction;
use SAAS\Domain\Users\Actions\UpsertPermissionAction;
use SAAS\Domain\Users\DataTransferObjects\PermissionData;
use SAAS\Domain\Users\Models\Permission;
use SAAS\Domain\Users\ViewModels\Admin\PermissionsIndexViewModel;
use SAAS\Domain\Users\ViewModels\Admin\UpsertPermissionViewModel;
use SAAS\Http\Permissions\Requests\PermissionStoreRequest;
use SAAS\Http\Permissions\Requests\PermissionUpdateRequest;

class PermissionController extends Controller
{
    /**
     * PermissionController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:browse permissions']);
        $this->middleware(['permission:create permission'])->only('create');
        $this->middleware(['permission:update permission'])->only('edit', 'update');
        $this->middleware(['permission:delete permission'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new PermissionsIndexViewModel($request);

        return Inertia::render('admin/views/permissions/Index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new UpsertPermissionViewModel();

        return Inertia::render('admin/views/permissions/Create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionStoreRequest $request)
    {
        try {
            $permission = UpsertPermissionAction::execute(
                PermissionData::fromRequest($request),
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return redirect()->route('admin.permissions.create', $permission)
                ->withError(__('Failed updating permission.'));
        }

        return redirect()->route('admin.permissions.index')
            ->withSuccess(__('\':name\' permission added successfully.', ['name' => $permission->name]));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $model = new UpsertPermissionViewModel($permission);

        return Inertia::render('admin/views/permissions/Edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        try {
            $permission = UpsertPermissionAction::execute(
                PermissionData::fromRequest($request),
                $permission
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return redirect()->route('admin.permissions.edit', $permission)
                ->withError(__('Failed updating permission.'));
        }

        return back()->withSuccess(__('Permission updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Permission $permission)
    {
        try {
            $deleted = DestroyPermissionAction::execute($permission);

            if (! $deleted) {
                return redirect()->route('admin.permissions.index')
                    ->withError(__('Failed deleting permission: ":name"', ['name' => $permission->name]));
            }
        } catch (\Exception $e) {
            return back()->withError(
                __('Some error occurred when deleting permission \':name\'.', ['name' => $permission->name])
            );
        }

        return back()->withSuccess(
            __('\':name\' permission deleted successfully.', ['name' => $permission->name])
        );
    }
}
