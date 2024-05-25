<?php

namespace SAAS\Domain\Companies\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;

class GetCompanySubscriptionCancellationViewModel extends ViewModel
{
    public function __construct(
        public readonly Company $company,
    ) {
        $this->company->loadMissing([
            'plans.features.feature',
            'subscriptions.items',
        ])->loadCount([
            'users',
        ]);
    }

    public function company()
    {
        return CompanyData::from($this->company);
    }
}
