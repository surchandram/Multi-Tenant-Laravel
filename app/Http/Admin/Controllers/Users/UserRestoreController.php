<?php

namespace SAAS\Http\Admin\Controllers\Users;

use SAAS\Domain\Users\Models\User;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Account\Events\AccountRestored;

class UserRestoreController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:browse users']);
        $this->middleware(['permission:delete user']);
        $this->middleware(['password.confirm'])->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::onlyTrashed()->filter($request)->orderBy('deleted_at', 'desc')->paginate();

        return view('admin.users.restore.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => ['required']
        ]);

        $user = User::onlyTrashed()->where('email', $request->email)->first();

        $user->restore();

        // fire event to notify user
        event(new AccountRestored($user));

        return redirect()->route('admin.users.edit', $user)->withSuccess(
            __('\':name\'s\' account restored.', ['name' => $user->name])
        );
    }
}
