<?php

namespace SAAS\Domain\Companies\ViewModels\Admin;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Addresses\DataTransferObjects\AddressData;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;

class ShowCompanyViewModel extends ViewModel
{
    public function __construct(
        public readonly Company $company,
    ) {
        $this->company->loadMissing([
            'addresses.country',
            'plans.features.feature',
        ])->loadCount([
            'users',
        ]);
    }

    public function company()
    {
        return CompanyData::fromModel($this->company);
    }

    public function addresses()
    {
        $addresses = AddressData::collection($this->company->addresses);

        return $addresses;
    }
}
