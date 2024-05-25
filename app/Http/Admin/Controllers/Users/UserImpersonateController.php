<?php

namespace SAAS\Http\Admin\Controllers\Users;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Admin\Actions\SetupUserImpersonationAction;
use SAAS\Domain\Admin\Actions\StopUserImpersonationAction;
use SAAS\Http\Admin\Requests\ImpersonateStartRequest;

class UserImpersonateController extends Controller
{
    /**
     * UserImpersonateController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:impersonate user'])->only('index', 'store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('admin/views/users/Impersonate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \SAAS\Http\Admin\Requests\ImpersonateStartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImpersonateStartRequest $request)
    {
        $user = SetupUserImpersonationAction::execute($request->email);

        session()->flash(
            'success',
            trans('messages.impersonate.started', ['name' => $user->name])
        );

        return Inertia::location(route('dashboard'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        StopUserImpersonationAction::execute();

        session()->flash(
            'success',
            trans('messages.impersonate.ended', ['name' => $user->name])
        );

        return Inertia::location(route('dashboard'));
    }
}
