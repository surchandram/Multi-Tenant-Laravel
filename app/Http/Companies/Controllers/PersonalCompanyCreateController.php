<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class PersonalCompanyCreateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('companies.create');
    }
}
