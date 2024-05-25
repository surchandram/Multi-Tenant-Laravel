<?php

namespace SAAS\Domain\Companies\ViewModels\Admin;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;

class GetCompaniesViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Request $request = null,
    ) {
    }

    public function companies()
    {
        return CompanyData::collection(
            Company::with([
                'addresses.country',
                'subscriptions.items',
            ])->latest('created_at')->paginate()
        );
    }
}
