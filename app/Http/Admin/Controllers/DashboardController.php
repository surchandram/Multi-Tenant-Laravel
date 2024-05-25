<?php

namespace SAAS\Http\Admin\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Admin\ViewModels\GetDashboardViewModel;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = new GetDashboardViewModel();

        return Inertia::render('admin/views/Dashboard', ['model' => $data]
        );
    }
}
