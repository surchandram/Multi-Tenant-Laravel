<?php

namespace SAAS\Http\Tenant\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Tenant\ViewModels\HomepageViewModel;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function __invoke(Request $request)
    {
        $model = new HomepageViewModel($request);

        return Inertia::render(
            'tenant/views/Home',
            compact('model')
        );
    }
}
