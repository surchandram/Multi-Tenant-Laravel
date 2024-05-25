<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\App\Support\Roles;
use SAAS\Domain\Companies\DataTransferObjects\CompaniesData;
use SAAS\Domain\Companies\Events\CompanyCreated;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\Repositories\CompanyRepository;
use SAAS\Domain\Companies\ViewModels\CreateCompanyViewModel;
use SAAS\Domain\Companies\ViewModels\EditCompanyViewModel;
use SAAS\Domain\Companies\ViewModels\ShowCompanyViewModel;
use SAAS\Domain\Users\Models\Role;
use SAAS\Http\Companies\Requests\CompanyStoreRequest;
use SAAS\Http\Companies\Requests\CompanyUpdateRequest;

class CompanyController extends Controller
{
    /**
     * Instance of DatabaseManager.
     *
     * @var \Illuminate\Database\DatabaseManager
     */
    private $db;

    /**
     * Instance of CompanyRepository.
     */
    protected CompanyRepository $companyRepository;

    /**
     * CompanyController constructor.
     *
     * @return void
     */
    public function __construct(Request $request, DatabaseManager $db, CompanyRepository $companyRepository)
    {
        $this->db = $db;
        $this->companyRepository = $companyRepository;

        $this->middleware(['auth']);
        $this->middleware(['in_team:'.$request->company])->except('index', 'create', 'store');
        $this->middleware(['permission:view company dashboard,company:'.($request->company)])->only('show');
        $this->middleware(['permission:update company,company:'.$request->company])->only('edit', 'update');
        $this->middleware(['permission:delete company,company:'.$request->company])->only('destroy');
        $this->middleware(['password.confirm'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Request $request)
    {
        $teams = CompaniesData::fromUser($request->user())->toArray();

        return Inertia::render('companies/views/Index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function create(Request $request)
    {
        $model = new CreateCompanyViewModel($request);

        return Inertia::render('companies/views/Create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyStoreRequest $request)
    {
        $user = $request->user();

        try {
            $company = $request->createCompany();

            // Get the default database connection from the ".env" file
            $dbConn = env('DB_CONNECTION');

            // Purge the "tenant" database connection
            $this->db->purge('tenant');

            // Set the default database connection
            $this->db->setDefaultConnection($dbConn);

            $role = Role::whereSlug(Roles::$roleWhenCreatingCompany)->first();

            $user->assignRole($role, null, $company);

            event(new CompanyCreated($company));
        } catch (\Exception $e) {
            Log::error('Failed creating company.', [$e]);

            return redirect()->back()->withErrors([
                'general' => __('app.company.create_failed'),
            ]);
        }

        session()->flash('success', __('app.company.created', ['name' => $company->name]));

        return Inertia::location(route('dashboard'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function show(Company $company)
    {
        $model = new ShowCompanyViewModel($company);

        return Inertia::render('companies/views/Show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function edit(Company $company)
    {
        $model = new EditCompanyViewModel($company);

        return Inertia::render('companies/views/Edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $company = $request->updateCompany();

        return redirect()->route('companies.edit', $company)->withSuccess(
            __('app.company.updated')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        try {
            $company->roles()->forceDelete();

            $company->delete();
        } catch (\Exception $e) {
            Log::error('Failed deleting company.', [$e]);

            return back()->withError(
                __('app.company.deletion_failed')
            );
        }

        return redirect()->route('companies.index')->withSuccess(
            __('app.company.deleted', ['name' => $company->name])
        );
    }
}
