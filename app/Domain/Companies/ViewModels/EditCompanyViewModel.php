<?php

namespace SAAS\Domain\Companies\ViewModels;

use SAAS\App\Support\Roles;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Addresses\DataTransferObjects\AddressData;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Countries\DataTransferObjects\CountryData;
use SAAS\Domain\Countries\Models\Country;
use SAAS\Domain\Teams\DataTransferObjects\TeamData;
use SAAS\Domain\Users\DataTransferObjects\PermissionData;
use SAAS\Domain\Users\DataTransferObjects\RoleData;
use SAAS\Domain\Users\Models\Permission;
use SAAS\Domain\Users\Models\Role;

class EditCompanyViewModel extends ViewModel
{
    protected ?Role $teamAdminrole;

    public function __construct(
        public readonly Company $company,
    ) {
        $this->company->loadMissing([
            'addresses.country',
            'users',
            'media',
        ]);

        $this->teamAdminrole = Role::with(['permissions'])->whereSlug(Roles::$roleWhenCreatingCompany)->first();
    }

    public function company()
    {
        return CompanyData::from($this->company);
    }

    public function addresses()
    {
        $addresses = AddressData::collection($this->company->addresses);

        return $addresses;
    }

    public function teams()
    {
        return TeamData::collection(
            $this->company->teams()->active()->get()
        );
    }

    public function countries()
    {
        return CountryData::collection(Country::get());
    }

    public function permissions()
    {
        return PermissionData::collection(
            Permission::active()->type(array_search(Company::class, config('laravel-roles.models')))->get()
        );
    }

    public function editableRoles()
    {
        $roles = $this->company->roles->loadMissing([
            'permissions',
        ]);

        if (filled($this->teamAdminrole)) {
            $roles->prepend($this->teamAdminrole);
        }

        return RoleData::collection($roles);
    }

    public function roles()
    {
        $roles = $this->company->roles->where('usable', true);

        if (filled($this->teamAdminrole)) {
            $roles->prepend($this->teamAdminrole);
        }

        return RoleData::collection($this->company->roles);
    }
}
