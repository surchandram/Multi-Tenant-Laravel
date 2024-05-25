<?php

namespace SAAS\Domain\WebApps\Actions;

use SAAS\Domain\Plans\Models\Plan;
use SAAS\Domain\Plans\Models\PlanApp;
use SAAS\Domain\WebApps\DataTransferObjects\AppPlanData;
use SAAS\Domain\WebApps\Models\App;

class CreateAppPlanAction
{
    public static function execute(AppPlanData $planData, App $app, Plan $plan): PlanApp
    {
        return $app->plans()->firstOrCreate([
            'plan_id' => $plan->id,
        ], [
            'per_seat' => $planData->per_seat,
            'is_unlimited' => $planData->is_unlimited,
            'limit' => $planData->limit ?? 0,
            'default' => $planData->default,
        ]);
    }
}
