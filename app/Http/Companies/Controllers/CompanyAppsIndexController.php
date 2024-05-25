<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\ManageCompanyAppsViewModel;

class CompanyAppsIndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function __invoke(Request $request, Company $company)
    {
        $model = new ManageCompanyAppsViewModel($company);

        return inertia('companies/views/apps/Index', compact('model'));
    }
}
