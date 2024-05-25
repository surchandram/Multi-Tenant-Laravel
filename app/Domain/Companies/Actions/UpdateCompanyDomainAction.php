<?php

namespace SAAS\Domain\Companies\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Companies\Models\Company;

class UpdateCompanyDomainAction
{
    public static function execute(string $domain, Company $company): Company
    {
        try {
            $company = DB::transaction(function () use ($domain, $company) {
                $company->update([
                    'domain' => $domain,
                    'data' => array_merge($company->data ?? [], [
                        'domain_updated_at' => now(),
                    ]),
                ]);

                return $company;
            });
        } catch (\Exception $exception) {
            Log::error('Failed updating company domain.', [$exception]);

            throw $exception;
        }

        return $company;
    }
}
