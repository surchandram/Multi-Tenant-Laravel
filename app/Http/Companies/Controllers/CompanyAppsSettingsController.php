<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\CompanyAppSettingsViewModel;
use SAAS\Domain\WebApps\Models\App;
use SAAS\Http\Companies\Requests\CompanyAppSettingsStoreRequest;

class CompanyAppsSettingsController extends Controller
{
    /**
     * CompanyAppsSettingsController constructor.
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
        $model = new CompanyAppSettingsViewModel($company, $app);

        return inertia(
            'companies/views/apps/Settings',
            compact('model')
        );
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyAppSettingsStoreRequest $request, Company $company, App $app)
    {
        $request->updateSettings();

        return redirect()->back()
            ->withSuccess(__('app.app.settings.updated'));
    }
}
