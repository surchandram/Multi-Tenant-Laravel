<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Actions\UpsertCompanyAppAction;
use SAAS\Domain\Companies\DataTransferObjects\CompanyAppData;
use SAAS\Domain\Companies\Models\Company;

class SetupAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Company $company)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        try {
            $app = UpsertCompanyAppAction::execute(
                CompanyAppData::fromRequest($request),
                $company
            );
        } catch (\Exception $e) {
            Log::error('Failed app setup for company.', [$e]);

            return back()->withError(__('app.company.app.setup_failed'));
        }

        return inertia()->location(
            route('tenant.switch', $company)
        );
    }
}
