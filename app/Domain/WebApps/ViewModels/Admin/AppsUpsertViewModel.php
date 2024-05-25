<?php

namespace SAAS\Domain\WebApps\ViewModels\Admin;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Features\Models\Feature;
use SAAS\Domain\Plans\Models\Plan;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\DataTransferObjects\AppFeatureData;
use SAAS\Domain\WebApps\Models\App;

class AppsUpsertViewModel extends ViewModel
{
    public function __construct(
        protected readonly ?Request $request = null,
        protected readonly ?App $app = null
    ) {
    }

    public function app()
    {
        $app = $this->app;

        if (empty($app)) {
            return [];
        }

        $app->loadMissing([
            'features.feature',
            'plans.plan',
            'media',
        ]);

        return AppData::fromModel($app)->all();
    }

    public function features()
    {
        return AppFeatureData::collection(Feature::active()->get());
    }

    public function apps()
    {
        return App::defaultOrder()->get();
    }

    public function plans()
    {
        return Plan::active()->get();
    }
}
