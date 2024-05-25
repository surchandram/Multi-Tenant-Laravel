<?php

namespace SAAS\Domain\Companies\DataTransferObjects;

use Illuminate\Support\Collection;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Users\Models\User;

class CompaniesData
{
    public function __construct(
        public Collection $companies
    ) {
    }

    /**
     * Get Companies collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function toArray()
    {
        return $this->companies;
    }

    /**
     * Setup listing for companies based on User model.
     *
     * @return \SAAS\Domain\Companies\DataTransferObjects\CompaniesData
     */
    public static function fromUser(User $user): CompaniesData
    {
        $companies = $user->companies()->with([
            'users' => (fn ($query) => $query->where('user_id', $user->id)),
            'users.roles' => function ($query) {
                $query->onlyValidRoles()->onlyForType(Company::class);
            },
        ])->get()->withCurrentUserRoles($user);

        return new self(
            companies: $companies
        );
    }
}
