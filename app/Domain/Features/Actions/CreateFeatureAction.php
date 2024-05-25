<?php

namespace SAAS\Domain\Features\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Features\DataTransferObjects\FeatureData;
use SAAS\Domain\Features\Models\Feature;

class CreateFeatureAction
{
    public static function execute(FeatureData $featureData): Feature
    {
        try {
            $model = DB::transaction(function () use ($featureData) {
                $feature = new Feature();
                $feature->fill($featureData->only('name', 'key', 'description')->toArray());
                $feature->usable = $featureData->usable ?? false;

                $feature->save();

                return $feature;
            });
        } catch (\Exception $e) {
            Log::error('Failed creating feature.', [$e]);

            throw $e;
        }

        return $model;
    }
}
