<?php

namespace SAAS\Domain\Companies\Actions;

use Illuminate\Support\Facades\Log;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Users\Models\User;

class CreateCompanyAction
{
    public static function execute(CompanyData $companyData, ?User $user): Company
    {
        try {
            $data = $companyData->only(
                'name',
                'email',
                'domain',
                'personal_team',
                'measurement_unit',
                'currency',
                'default_tax',
                'license_no',
                'tax_id',
                'projects_prefix',
            )->additional([
                'user_id' => $user?->id,
            ]);

            // create company
            $company = $user->companies()->create($data->all());

            if (filled($companyData->logo)) {
                $company->uploadLogo($companyData->logo);
            }

            if (filled($companyData->apps)) {
                $companyData->apps->each(
                    fn ($companyAppData) => SetupCompanyAppAction::execute($companyAppData, $company)
                );
            }
        } catch (\Exception $exception) {
            Log::error('Failed creating company.', [$exception]);

            throw $exception;
        }

        return $company;
    }
}
