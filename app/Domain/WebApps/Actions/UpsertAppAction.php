<?php

namespace SAAS\Domain\WebApps\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\Models\App;

class UpsertAppAction
{
    use UpsertTrait;

    public static function execute(AppData $data): App
    {
        $app = DB::transaction(function () use ($data) {
            return self::saveApp($data);
        });

        return $app;
    }

    public static function saveApp(AppData $data): App
    {
        $app = App::firstOrCreate([
            'key' => $data->key,
        ], $data->only(
            'name',
            'key',
            'description',
            'url',
            'usable',
            'teams_only',
            'primary',
            'subscription',
        )->all());

        // logo handling
        if (! empty($data->logo)) {
            $app->uploadLogo($data->logo);
        }

        // create features and attach to app
        if (! empty($data->features)) {
            self::createFeatures($data->features, $app);
        }

        // create plans and attach to app
        if (! empty($data->plans)) {
            self::createPlans($data->plans, $app);
        }

        return $app->fresh(['features.feature', 'plans.plan', 'media']);
    }
}
