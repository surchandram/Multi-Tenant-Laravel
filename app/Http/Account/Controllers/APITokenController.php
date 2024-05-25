<?php

namespace SAAS\Http\Account\Controllers;

use SAAS\App\Controllers\Controller;
use Illuminate\Http\Request;

class APITokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('account.tokens.index');
    }
}
