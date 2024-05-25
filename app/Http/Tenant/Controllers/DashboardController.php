<?php

namespace SAAS\Http\Tenant\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Tenant\ViewModels\GetDashboardViewModel;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function __invoke(Request $request)
    {
        abort_if(
            Gate::denies('view company dashboard', $request->tenant()),
            403
        );

        $model = new GetDashboardViewModel();

        return Inertia::render(
            'tenant/views/Dashboard',
            compact('model')
        );
    }
}
