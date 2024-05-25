<?php

namespace SAAS\Domain\Plans\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\App\Payments\Gateway;
use SAAS\Domain\Features\Models\Feature;
use SAAS\Domain\Plans\DataTransferObjects\PlanData;
use SAAS\Domain\Plans\Models\Plan;
use SAAS\Domain\Plans\Models\PlanFeature;

class CreatePlanAction
{
    public static function execute(PlanData $planData): Plan
    {
        $gateway = app(Gateway::class);
        try {
            $model = DB::transaction(function () use ($planData, $gateway) {
                $providerPlan = $gateway->createPlan($planData);

                $plan = new Plan();
                $plan->fill($planData->only('name', 'interval', 'provider_id', 'price', 'description')->toArray());
                $plan->teams = $planData->teams ?? false;
                $plan->per_seat = $planData->per_seat ?? false;
                $plan->gateway_id = $providerPlan?->id;
                $plan->synced_to_provider = true;
                $plan->usable = $planData->usable ?? false;
                $plan->save();

                if ($plan->teams) {
                    if (! $plan->per_seat && ($feature = Feature::where('key', 'users')->first())) {
                        $planFeature = new PlanFeature();
                        $planFeature->limit = $planData->team_limit ?? 2;
                        $planFeature->default = true;

                        $planFeature->feature()->associate($feature);

                        $plan->features()->save($planFeature);
                    }
                }

                return $plan;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $model;
    }
}
