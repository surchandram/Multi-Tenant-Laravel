<?php

namespace SAAS\Domain\Companies\Actions;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Miracuthbert\Multitenancy\Models\Tenant;
use SAAS\Domain\Companies\DataTransferObjects\CompanyAppData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\Models\CompanyApp;

class RunAppSetupTasksAction
{
    public static function execute(CompanyApp $companyApp, Company $company): CompanyApp
    {
        try {
            // todo: migrate, seed or update config for company app in sequence

            if (self::migrate($company, $companyApp)) {
                $seeded = self::seed($company, $companyApp);

                if ($seeded) {
                    UpsertCompanyAppAction::execute(
                        CompanyAppData::fromModel($companyApp->loadMissing('app')),
                        $company
                    );
                    Log::info("{$companyApp->app->name} tasks running for $company->name");
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed running tasks for [{$companyApp->app->name}] for company [$company->name].", [$e]);

            throw $e;
        }

        return $companyApp;
    }

    /**
     * Migrate tenant's database.
     *
     * @return bool
     */
    protected static function migrate(Tenant $tenant, CompanyApp $companyApp)
    {
        $migration = Artisan::call('tenants:migrate', [
            '--tenants' => [$tenant->id],
            '--path' => 'database/migrations/tenant/'.$companyApp->key,
            '--force' => true,
        ]);

        return $migration === 0;
    }

    /**
     * Seed tenant's database.
     *
     * @return int
     */
    protected static function seed(Tenant $tenant, CompanyApp $companyApp)
    {
        $seeded = Artisan::call('tenants:seed', [
            '--tenants' => [$tenant->id],
            '--force' => true,
        ]);

        return $seeded === 0;
    }
}
