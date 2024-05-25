<?php

namespace SAAS\Domain\Companies\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Companies\DataTransferObjects\CompanyAppData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\Models\CompanyApp;

class UpsertCompanyAppAction
{
    public static function execute(CompanyAppData $companyAppData, Company $company = null): CompanyApp
    {
        try {
            $companyApp = DB::transaction(function () use ($companyAppData, $company) {
                $app = CompanyApp::firstOrNew([
                    'company_id' => $companyAppData->company?->id ?? $company?->id,
                    'app_id' => $companyAppData->app->id,
                ]);

                $app->setup_at = ! filled($app->setup_at) ? now() : $app->setup_at;

                if ($app->exists) {
                    $app->last_patched_at = now();
                    $app->data = array_merge($app->data, Arr::wrap($companyAppData->data));
                }

                $app->save();

                return $app;
            });
        } catch (\Exception $e) {
            Log::error('Failed setting up company app.', [$e]);

            throw $e;
        }

        return $companyApp;
    }
}
