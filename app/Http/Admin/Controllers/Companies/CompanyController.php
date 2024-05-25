<?php

namespace SAAS\Http\Admin\Controllers\Companies;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Actions\DestroyCompanyAction;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\Admin\GetCompaniesViewModel;
use SAAS\Domain\Companies\ViewModels\Admin\ShowCompanyViewModel;
use SAAS\Http\Companies\Requests\CompanyUpdateRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Request $request)
    {
        $model = new GetCompaniesViewModel($request);

        return Inertia::render('admin/views/companies/Index', compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function show(Company $company)
    {
        $model = new ShowCompanyViewModel($company);

        return Inertia::render('admin/views/companies/Show', compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Momentum\Modal\Modal
     */
    public function edit(Request $request, Company $company)
    {
        $model = new ShowCompanyViewModel($company);

        return inertia()
            ->modal('admin/modals/companies/EditCompanyDrawer', compact('model'))
            ->baseRoute('admin.companies.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $request->updateCompany();

        return redirect()->route('admin.companies.show', $company)
            ->withSuccess(__('app.company.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $deleted = DestroyCompanyAction::execute($company);

        if ($deleted) {
            return redirect()->route('admin.companies.index')->withSuccess(__('app.company.deleted', ['name' => $company->name]));
        }

        return back()->withError(__('app.company.deletion_failed'));
    }
}
