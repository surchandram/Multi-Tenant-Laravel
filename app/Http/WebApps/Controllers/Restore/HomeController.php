<?php

namespace SAAS\Http\WebApps\Controllers\Restore;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // abort_if(Gate::denies('view team dashboard', $request->tenant()), 403);

        return Inertia::render('tenant/views/restore/Home');
    }
}
