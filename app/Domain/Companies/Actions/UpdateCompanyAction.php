<?php

namespace SAAS\Domain\Companies\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;

class UpdateCompanyAction
{
    public static function execute(CompanyData $companyData, Company $company): Company
    {
        try {
            $company = DB::transaction(function () use ($companyData, $company) {
                $data = $companyData->only(
                    'name',
                    'email',
                    'personal_team',
                    'measurement_unit',
                    'currency',
                    'default_tax',
                    'license_no',
                    'tax_id',
                    'projects_prefix',
                );

                $company->update($data->all());

                if (filled($companyData->logo)) {
                    $company->uploadLogo($companyData->logo);
                }

                return $company->fresh();
            });
        } catch (\Exception $exception) {
            Log::error('Failed updating company details.', [$exception]);

            throw $exception;
        }

        return $company;
    }
}
