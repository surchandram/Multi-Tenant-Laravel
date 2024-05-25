<?php

namespace SAAS\Http\Home\Controllers;

use Inertia\Inertia;
use SAAS\App\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }


    public function index()
    {
        // return Inertia::render('home/views/SaasLandingPage');
        return redirect('/login');
    }
}
