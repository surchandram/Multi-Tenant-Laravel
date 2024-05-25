<?php

namespace SAAS\Domain\Companies\ViewModels;

use SAAS\App\Support\Roles;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Teams\DataTransferObjects\TeamData;
use SAAS\Domain\Users\DataTransferObjects\RoleData;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use SAAS\Domain\Users\Models\Role;
use SAAS\Domain\Users\Models\User;

class EditCompanyUserViewModel extends ViewModel
{
    public function __construct(
        public readonly Company $company,
        public readonly User $user,
    ) {
        $this->user->loadMissing([
            'roles' => function ($query) {
                $query->where('permitable_id', $this->company->id)
                    ->orWhereHasMorph('roleable', Company::class, function ($query) {
                        $query->where('id', $this->company->id);
                    })
                    ->wherePivotNull('expires_at')
                    ->orderByPivot('created_at', 'desc');
            },
            'companies' => function ($query) {
                $query->where('companies.id', $this->company->id);
            },
            'companies.teams.users' => function ($query) {
                $query->where('user_id', $this->user->id);
            },
        ]);
    }

    public function currentTeam()
    {
        $teams = $this->user->companies->first()?->teams;

        if (count($teams) < 1) {
            return [];
        }

        return TeamData::from($teams?->first());
    }

    public function currentRole()
    {
        return RoleData::fromModel($this->user->roles->first());
    }

    public function user()
    {
        return UserData::from($this->user);
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
