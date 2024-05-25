<?php

namespace SAAS\Http\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\App\Providers\RouteServiceProvider;
use SAAS\Http\Auth\Requests\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        if (filled($request->redirect_to)) {
            $request->session()->put('url.intended', $request->redirect_to);
        }

        return Inertia::render('auth/views/Login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $path = $request->session()->pull('url.intended', RouteServiceProvider::HOME);

        return Inertia::location($path);
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Inertia::location('/');
    }
}
