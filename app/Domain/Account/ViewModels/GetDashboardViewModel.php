<?php

namespace SAAS\Domain\Account\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;

class GetDashboardViewModel extends ViewModel
{
    public function companies()
    {
        $companies = auth()->user()->companies;

        return CompanyData::collection($companies);
    }
}
