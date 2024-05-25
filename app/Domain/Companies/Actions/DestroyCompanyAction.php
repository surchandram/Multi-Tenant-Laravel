<?php

namespace SAAS\Domain\Companies\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Companies\Models\Company;

class DestroyCompanyAction
{
    public static function execute(Company $company): ?bool
    {
        try {
            return DB::transaction(function () use ($company) {
                return $company->delete();
            });
        } catch (\Exception $exception) {
            Log::error('Failed deleting company.', [$exception]);

            throw $exception;
        }
    }
}
