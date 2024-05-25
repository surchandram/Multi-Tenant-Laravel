<?php

namespace SAAS\Domain\Companies\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\Enums\Apps\Restore;
use SAAS\Domain\WebApps\Models\App;

class CompanyAppSettingsViewModel extends ViewModel
{
    public function __construct(
        public readonly Company $company,
        public readonly App $app,
    ) {
    }

    public function settings()
    {
        return array_merge(
            Restore::settings(),
            $this->company->apps->where('app_id', $this->app->id)
                ->first()?->data['options'] ?? []
        );
    }

    public function company()
    {
        return CompanyData::from($this->company);
    }

    public function app()
    {
        return AppData::fromModel(
            $this->app->load('features.feature')
        );
    }
}
