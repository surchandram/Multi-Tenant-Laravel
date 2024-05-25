<?php

namespace SAAS\Http\Account\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;

class AccountController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('account/views/Index');
    }
}
