<?php

namespace SAAS\Http\Account\Controllers;

use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Http\Account\Requests\ProfileStoreRequest;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index()
    {
        return Inertia::render('account/views/Profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileStoreRequest $request)
    {
        //update user
        $user = $request->updateProfile();

        if (! $user->wasChanged()) {
            return redirect()->route('account.profile.index');
        }

        //redirect with success
        return redirect()->route('account.profile.index')->withSuccess(__('app.account.profile.updated'));
    }
}
