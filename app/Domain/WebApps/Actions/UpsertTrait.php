<?php

namespace SAAS\Domain\WebApps\Actions;

use SAAS\Domain\Features\Models\Feature;
use SAAS\Domain\Plans\Models\Plan;
use SAAS\Domain\WebApps\DataTransferObjects\AppFeatureData;
use SAAS\Domain\WebApps\DataTransferObjects\AppPlanData;
use SAAS\Domain\WebApps\Models\App;
use Spatie\LaravelData\DataCollection;

trait UpsertTrait
{
    public static function getOrCreatePlan(AppPlanData $data)
    {
        $plan = Plan::firstOrNew([
            'provider_id' => $data->provider_id,
        ], $data->all());

        if (! $plan->exists) {
            $plan->save();
        }

        return $plan;
    }

    public static function getOrCreateFeature(AppFeatureData $data, App $app)
    {
        $feature = Feature::firstOrNew([
            'key' => $data->key,
        ],
            $data->except('id', 'default', 'limit')->all()
        );

        if (! $feature->exists) {
            $feature->featurable()->associate($app)->save();
        }

        return $feature;
    }

    public static function createFeatures(DataCollection $features, App $app)
    {
        $features->each(function (AppFeatureData $featureData) use ($app) {
            $feature = self::getOrCreateFeature($featureData, $app);

            // link feature to app
            CreateAppFeatureAction::execute(
                $featureData, $app, $feature
            );
        });
    }

    public static function createPlans(DataCollection $plans, App $app)
    {
        $plans->each(function (AppPlanData $planData) use ($app) {
            /** @var \SAAS\Domain\Plans\Models\Plan $plan */
            $plan = self::getOrCreatePlan($planData);

            // link plan to app
            CreateAppPlanAction::execute($planData, $app, $plan);

            // create plan features
            $planData->features->each(function (AppFeatureData $featureData) use ($plan) {
                $feature = Feature::where('key', $featureData->key)->firstOrFail();

                // link feature to plan
                CreatePlanFeatureAction::execute($featureData, $plan, $feature);
            });
        });
    }
}
