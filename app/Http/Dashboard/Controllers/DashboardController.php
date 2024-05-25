<?php

namespace SAAS\Http\Dashboard\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Account\ViewModels\GetDashboardViewModel;

class DashboardController extends Controller
{
    /**
     * DashboardController Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $model = new GetDashboardViewModel();

        return Inertia::render(
            'dashboard/views/Dashboard',
            compact('model')
        );
    }
}
