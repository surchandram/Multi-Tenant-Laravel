<?php

namespace SAAS\Domain\WebApps\Actions;

use SAAS\Domain\Features\Models\Feature;
use SAAS\Domain\WebApps\DataTransferObjects\AppFeatureData;
use SAAS\Domain\WebApps\Models\App;
use SAAS\Domain\WebApps\Models\AppFeature;

class CreateAppFeatureAction
{
    public static function execute(AppFeatureData $featureData, App $app, Feature $feature): AppFeature
    {
        return $app->features()->updateOrCreate([
            'feature_id' => $feature->id,
        ], [
            'is_unlimited' => $featureData->is_unlimited,
            'limit' => $featureData->limit,
            'default' => $featureData->default,
        ]);
    }
}
