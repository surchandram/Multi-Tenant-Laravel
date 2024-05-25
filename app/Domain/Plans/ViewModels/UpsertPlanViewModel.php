<?php

namespace SAAS\Domain\Plans\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Features\DataTransferObjects\FeatureData;
use SAAS\Domain\Features\Models\Feature;
use SAAS\Domain\Plans\DataTransferObjects\PlanData;
use SAAS\Domain\Plans\Models\Plan;

class UpsertPlanViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Plan $plan = null,
    ) {
        if ($this->plan) {
            $this->plan->loadMissing([
                'features',
            ]);
        }
    }

    public function intervals()
    {
        return Plan::$intervals;
    }

    public function plans()
    {
        return PlanData::collection(
            Plan::get()
        );
    }

    public function features()
    {
        return FeatureData::collection(
            Feature::active()->get()
        );
    }

    public function plan()
    {
        if (! $this->plan) {
            return [];
        }

        return PlanData::fromModel($this->plan);
    }
}
