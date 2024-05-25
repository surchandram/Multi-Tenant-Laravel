<?php

namespace SAAS\Http\Admin\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Users\Actions\AssignUserRoleAction;
use SAAS\Domain\Users\DataTransferObjects\UserRoleData;
use SAAS\Domain\Users\Models\Role;
use SAAS\Domain\Users\Models\User;
use SAAS\Http\Users\Requests\UserRoleStoreRequest;

class UserRoleController extends Controller
{
    /**
     * UserRoleController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:assign roles']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRoleStoreRequest $request, User $user)
    {
        $role = Role::find($request->role_id);

        if (! AssignUserRoleAction::execute(UserRoleData::fromRequest($request), $user)) {
            return redirect()->route('admin.users.edit', $user)
                ->withErrors([
                    'role_id' => __('Failed assigning role.'),
                ])
                ->withError(
                    __('Whoops! Failed assigning :name role to user.', ['name' => $role->name])
                );
        }

        return redirect()->route('admin.users.edit', $user)->withSuccess(
            __('\':name\' role assigned to user.', ['name' => $role->name])
        );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Role $role)
    {
        return view('admin.users.roles.edit', compact('user', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Role $role)
    {
        $user->revokeRoleAt($role, $request->expires_at);

        return redirect()->route('admin.users.edit', $user)
            ->withSuccess(__('User\'s \':role\' updated.', ['role' => $role->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Role $role)
    {
        // check if admin user can be deleted
        if ($role->type == Role::ADMIN && $role->slug == 'admin-root') {

            // abort if no admin delete privilege
            abort_if(Gate::denies('delete admins'), 404);

            // check if user is the last
            if ($user->isLastAdmin($role)) {
                return back()->withError(
                    __('Only one \'Admin\' user left, at least add one more before removing the existing one.')
                );
            }
        }

        if (! $user->revokeRoleAt($role)) {
            return redirect()->route('admin.users.edit', $user)
                ->withError(__('Failed revoking :name role from user.', ['role' => $role->name]));
        }

        return redirect()->route('admin.users.edit', $user)
            ->withSuccess(__('User\'s \':role\' role revoked.', ['role' => $role->name]));
    }
}
