<?php

namespace SAAS\Domain\Companies\ViewModels;

use Illuminate\Support\Str;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;

class UpdateCompanyPaymentmethodViewModel extends ViewModel
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

    public function cardType()
    {
        return Str::ucfirst($this->company->pm_type);
    }

    public function lastFour()
    {
        return $this->company->pm_last_four;
    }

    public function setupIntent()
    {
        return $this->company->createSetupIntent()?->client_secret;
    }

    public function company()
    {
        return CompanyData::from($this->company);
    }
}
