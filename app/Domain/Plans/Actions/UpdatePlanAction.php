<?php

namespace SAAS\Domain\Plans\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Plans\DataTransferObjects\PlanData;
use SAAS\Domain\Plans\Models\Plan;

class UpdatePlanAction
{
    public static function execute(PlanData $planData, Plan $plan): Plan
    {
        try {
            $model = DB::transaction(function () use ($planData, $plan) {
                $data = [
                    'description' => $planData->description,
                    'usable' => $planData->usable,
                ];

                $plan->update($data);

                return $plan->refresh();
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $model;
    }
}
