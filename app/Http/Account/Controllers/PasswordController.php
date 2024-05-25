<?php

namespace SAAS\Http\Account\Controllers;

use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Account\Events\PasswordUpdated;
use SAAS\Http\Account\Requests\PasswordStoreRequest;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index()
    {
        return Inertia::render('account/views/security/ChangePassword');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PasswordStoreRequest $request)
    {
        // update user password
        $request->user()->update(['password' => bcrypt($request->password)]);

        // send email
        event(new PasswordUpdated($request->user()));

        // redirect with success
        return redirect()
            ->route('account.index')
            ->withSuccess('Password updated successfully.');
    }
}
