<?php

namespace SAAS\Domain\Companies\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\App\Exceptions\Logo\CannotUploadLogo;
use SAAS\App\Repositories\RepositoryAbstract;
use SAAS\Domain\Companies\DataTransferObjects\CreateCompanyData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Users\Models\User;

class CompanyRepository extends RepositoryAbstract
{
    /**
     * Define the repository's entity.
     *
     * @return string
     */
    public function entity()
    {
        return Company::class;
    }

    public function createForUser($data, ?User $user)
    {
        $company = $user->companies()->create(
            CreateCompanyData::make(
                $data,
                $user
            )->toArray()
        );

        if (Arr::has($data, 'logo') && ! empty($data['logo'])) {
            $this->uploadLogo($company, $data['logo']);
        }

        return $company;
    }

    public function uploadLogo($id, $logo)
    {
        $company = $this->findFirst($id);

        try {
            $media = DB::transaction(function () use (&$company, $logo) {
                return $company->uploadLogo($logo);
            });

            Log::info('Company logo uploaded', ['media' => $media]);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw CannotUploadLogo::because($e->getMessage(), $e->getTrace());
        }
    }

    public function assignUserRole($id, User $user, $role, $expiresAt = null)
    {
        $this->findFirst($id)->assignRole(
            $user, $role, $expiresAt
        );
    }

    public function revokeRole($id, User $user, $role, $expiresAt = null)
    {
        $this->findFirst($id)->revokeRole($user, $role, $expiresAt);
    }
}
