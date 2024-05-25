<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\SetupCompanyAppViewModel;
use SAAS\Domain\WebApps\Models\App;
use SAAS\Http\Companies\Requests\CompanyAppStoreRequest;

class CompanyAppSetupController extends Controller
{
    /**
     * CompanyAppSetupController constructor.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Request $request, Company $company, App $app)
    {
        $model = new SetupCompanyAppViewModel($company, $app);

        return inertia('companies/views/apps/Setup', compact('model'));
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyAppStoreRequest $request, Company $company, App $app)
    {
        $request->setupApp();

        return inertia()->location(
            route('tenant.switch', $company)
        );
    }
}
