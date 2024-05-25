<?php

namespace SAAS\Domain\Companies\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Plans\DataTransferObjects\PlanData;
use SAAS\Domain\Plans\Models\Plan;

class GetCompanySubscriptionsViewModel extends ViewModel
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

    public function setupIntent()
    {
        if ($this->company->hasSubscription()) {
            return null;
        }

        return $this->company->createSetupIntent()?->client_secret;
    }

    public function company()
    {
        return CompanyData::from($this->company);
    }

    public function plans()
    {
        $plans = PlanData::collection(
            Plan::with(['features.feature'])->withActiveFeatures()->active()->forTeams()->get()
        );

        return $plans;
    }
}
