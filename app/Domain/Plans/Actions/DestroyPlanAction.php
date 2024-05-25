<?php

namespace SAAS\Domain\Plans\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\App\Payments\Gateway;
use SAAS\Domain\Plans\DataTransferObjects\PlanData;
use SAAS\Domain\Plans\Models\Plan;

class DestroyPlanAction
{
    public static function execute(Plan $plan): bool
    {
        $gateway = app(Gateway::class);

        try {
            $deleted = DB::transaction(function () use ($plan, $gateway) {
                // 'delete' (set active to false) in payment provider
                if (! $gateway->deletePlan(PlanData::fromModel($plan))) {
                    return false;
                }

                // soft delete model
                return $plan->delete();
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $deleted;
    }
}
