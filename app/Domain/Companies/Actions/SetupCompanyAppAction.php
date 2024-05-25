<?php

namespace SAAS\Domain\Companies\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Companies\DataTransferObjects\CompanyAppData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\Models\CompanyApp;

class SetupCompanyAppAction
{
    public static function execute(CompanyAppData $companyAppData, Company $company = null): CompanyApp
    {
        try {
            $companyApp = DB::transaction(function () use ($companyAppData, $company) {
                return CompanyApp::create([
                    'company_id' => $companyAppData->company?->id ?? $company?->id,
                    'app_id' => $companyAppData->app->id,
                    'setup_at' => null,
                    'last_patched_at' => null,
                    'data' => Arr::wrap($companyAppData->data),
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Failed setting up company app.', [$e]);

            throw $e;
        }

        return $companyApp;
    }
}
