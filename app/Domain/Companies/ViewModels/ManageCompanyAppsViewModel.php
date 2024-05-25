<?php

namespace SAAS\Domain\Companies\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\Models\App;

class ManageCompanyAppsViewModel extends ViewModel
{
    public function __construct(
        public readonly Company $company,
    ) {
        $this->company->load('apps.app');
    }

    public function company()
    {
        return CompanyData::from($this->company);
    }

    public function apps()
    {
        $apps = App::with([
            'features.feature',
        ])->active()->get();

        return AppData::collection($apps);
    }
}
