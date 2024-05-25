<?php

namespace SAAS\Domain\Features\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Features\DataTransferObjects\FeatureData;
use SAAS\Domain\Features\Models\Feature;

class UpdateFeatureAction
{
    public static function execute(FeatureData $featureData, Feature $feature): Feature
    {
        try {
            $model = DB::transaction(function () use ($featureData, $feature) {
                $data = [
                    'name' => $featureData->name,
                    'description' => $featureData->description,
                    'usable' => $featureData->usable,
                    'trial_limit' => $featureData->trial_limit,
                    'is_unlimited' => $featureData->is_unlimited,
                ];

                $feature->update($data);

                return $feature->refresh();
            });
        } catch (\Exception $e) {
            Log::error('Failed updating feature.', [$e]);

            throw $e;
        }

        return $model;
    }
}
