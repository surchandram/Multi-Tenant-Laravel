<?php

namespace SAAS\Http\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\App\Providers\RouteServiceProvider;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        if (! $request->redirect) {
            return back()->with('status', 'verification-link-sent');
        }

        $query = parse_url($request->redirect, PHP_URL_QUERY);
        $query = array_merge(Arr::wrap($query), ['status' => 'verification-link-sent']);

        $redirect = Str::of($request->redirect)->explode('?')->first();

        $url = URL::to($redirect.'?'.Arr::query($query));

        return Inertia::location($url);
    }
}
