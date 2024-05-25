<?php

namespace SAAS\Http\Companies\Controllers;

use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\Admin\ShowCompanyViewModel;
use SAAS\Http\Companies\Requests\CompanyDomainStoreRequest;

class CompanyDomainController extends Controller
{
    /**
     * Show the form for editing the resource.
     *
     * @return \Illuminate\Http\Response|\Momentum\Modal\Modal
     */
    public function index(Company $company)
    {
        $model = new ShowCompanyViewModel($company);

        return inertia()
            ->modal('companies/modals/ChangeDomain', compact('model'))
            ->baseRoute('companies.show', $company);
    }

    /**
     * Store the newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyDomainStoreRequest $request, Company $company)
    {
        $request->updateDomain();

        return redirect()->route('companies.show', $company)
            ->withSuccess(__('app.company.domain_updated'));
    }
}
