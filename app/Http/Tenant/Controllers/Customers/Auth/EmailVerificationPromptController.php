<?php

namespace SAAS\Http\Tenant\Controllers\Customers\Auth;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;

class EmailVerificationPromptController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('tenant.customers.portal.dashboard');
        }

        return Inertia::render('tenant/views/customers/portal/auth/VerifyEmail');
    }
}
