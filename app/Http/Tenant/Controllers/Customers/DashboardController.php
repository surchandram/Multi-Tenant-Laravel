<?php

namespace SAAS\Http\Tenant\Controllers\Customers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Tenant\ViewModels\CustomerPortal\GetDashboardViewModel;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $model = new GetDashboardViewModel($request);

        return Inertia::render('tenant/views/customers/portal/Dashboard', compact('model'));
    }
}
