<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Users\Models\User;

class CompanyUserDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Company $company, User $user)
    {
        if (! $company->users->contains($user)) {
            return back();
        }

        if ($user->isOnlyAdminInCompany($company)) {
            return back();
        }

        if ($company->users->count() === 1) {
            return back();
        }

        abort_if(Gate::denies('delete company user', $company), 403);

        return view('companies.users.delete', compact('company', 'user'));
    }
}
