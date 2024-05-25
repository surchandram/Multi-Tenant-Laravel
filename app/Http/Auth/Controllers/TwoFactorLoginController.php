<?php

namespace SAAS\Http\Auth\Controllers;

use SAAS\Http\TwoFactor\Requests\TwoFactorVerifyRequest;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TwoFactorLoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Display the two factor login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.twofactor.index');
    }

    /**
     * Login the verified user.
     *
     * @param  TwoFactorVerifyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TwoFactorVerifyRequest $request)
    {
        Auth::loginUsingId($request->user()->id, session('twofactor')->remember);

        session()->forget('twofactor');

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return $this->redirectTo;
    }
}
