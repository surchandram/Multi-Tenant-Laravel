<?php

namespace SAAS\Http\Tenant\Controllers\Customers\Auth;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;

class AuthenticateCustomerFormController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function __invoke(Request $request)
    {
        Inertia::share('redirect_url', $request->redirect);

        return Inertia::render('tenant/views/customers/portal/auth/Login');
    }
}
