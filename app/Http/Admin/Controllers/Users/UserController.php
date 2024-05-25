<?php

namespace SAAS\Http\Admin\Controllers\Users;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Users\Actions\SendUserInvitationAction;
use SAAS\Domain\Users\DataTransferObjects\UserInvitationData;
use SAAS\Domain\Users\Models\User;
use SAAS\Domain\Users\ViewModels\Admin\UpsertUserViewModel;
use SAAS\Domain\Users\ViewModels\Admin\UsersIndexViewModel;
use SAAS\Http\Users\Requests\UserInvitationStoreRequest;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:browse users']);
        $this->middleware(['permission:create user'])->only('create', 'store');
        $this->middleware(['permission:update user'])->only('edit', 'update');
        $this->middleware(['permission:delete user'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new UsersIndexViewModel($request);

        return Inertia::render('admin/views/users/Index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new UpsertUserViewModel();

        return Inertia::render('admin/views/users/Create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserInvitationStoreRequest $request)
    {
        $invitation = SendUserInvitationAction::execute(
            UserInvitationData::fromRequest($request, $request->user())
        );

        if ($invitation->id) {
            return back()->withSuccess(__('Invitation sent successfully.'));
        }

        return back()->withInput()->withError(__('Failed sending invitation.'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return back()->withInfo(__('Feature still under development.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $model = new UpsertUserViewModel($user);

        return Inertia::render('admin/views/users/Edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return back()->withInfo(__('Feature still under development.'));
    }
}
