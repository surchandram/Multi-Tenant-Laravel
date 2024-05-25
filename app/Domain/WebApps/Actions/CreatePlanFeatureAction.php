<?php

namespace SAAS\Domain\WebApps\Actions;

use SAAS\Domain\Features\Models\Feature;
use SAAS\Domain\Plans\Models\Plan;
use SAAS\Domain\Plans\Models\PlanFeature;
use SAAS\Domain\WebApps\DataTransferObjects\AppFeatureData;

class CreatePlanFeatureAction
{
    public static function execute(AppFeatureData $featureData, Plan $plan, Feature $feature): PlanFeature
    {
        return $plan->features()->firstOrCreate([
            'plan_id' => $plan->id,
            'feature_id' => $feature->id,
        ], [
            'is_unlimited' => $featureData->is_unlimited,
            'limit' => $featureData->limit,
            'default' => $featureData->default,
        ]);
    }
}
