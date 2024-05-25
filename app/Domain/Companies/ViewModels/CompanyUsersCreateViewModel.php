<?php

namespace SAAS\Domain\Companies\ViewModels;

use SAAS\App\Support\Roles;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Teams\DataTransferObjects\TeamData;
use SAAS\Domain\Users\Models\Role;

class CompanyUsersCreateViewModel extends ViewModel
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

        $role = Role::whereSlug(Roles::$roleWhenCreatingCompany)->first();

        $this->company->roles->prepend($role);

        return $this->company->roles;
    }
}
