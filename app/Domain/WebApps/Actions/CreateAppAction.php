<?php

namespace SAAS\Domain\WebApps\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\Models\App;

class CreateAppAction
{
    use UpsertTrait;

    public function __construct()
    {
    }

    public static function execute(AppData $data): App
    {
        $app = DB::transaction(function () use ($data) {
            return self::saveApp($data);
        });

        return $app;
    }

    public static function saveApp(AppData $data): App
    {
        $app = new App();
        $app->fill($data->all());
        $app->save();

        // create features and attach to app
        if (! empty($data->features)) {
            self::createFeatures($data->features, $app);
        }

        // create plans and attach to app
        if (! empty($data->plans)) {
            self::createPlans($data->plans, $app);
        }

        return $app->load(['features.feature', 'plans.plan', 'media']);
    }
}
