<?php

namespace SAAS\Domain\Teams\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Teams\DataTransferObjects\TeamData;

class TeamUserCreateViewModel extends ViewModel
{
    public function __construct(
        public readonly Company $company,
    ) {
    }

    public function company()
    {
        return CompanyData::from($this->company);
    }

    public function teams()
    {
        return TeamData::collection(
            $this->company->teams()->active()->get()
        );
    }

    public function roles()
    {
        $this->company->loadMissing([
            'roles' => function ($query) {
                $query->active();
            },
        ]);

        $this->company->allRoles();

        return $this->company->roles;
    }
}
