<?php

namespace SAAS\Http\Account\Controllers;

use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Account\Events\AccountDeactivated;
use SAAS\Http\Account\Requests\DeactivateAccountRequest;

class DeactivateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index()
    {
        return Inertia::render('account/views/Deactivate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DeactivateAccountRequest $request)
    {
        $user = $request->user();

        // cancel subscriptions or any other action...
        if ($user->hasSubscription()) {
            $user->currentSubscription()->cancel();
        }

        // soft delete account
        $user->delete();

        // fire event to notify user
        event(new AccountDeactivated($user));

        return redirect()->route('home')->withSuccess(__('Your account has been deactivated.'));
    }
}
