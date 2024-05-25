<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;

class CompanyDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Company $company)
    {
        abort_if(Gate::denies('delete company', $company), 403);

        return view('companies.delete', compact('company'));
    }
}
