<?php

namespace SAAS\Domain\WebApps\ViewModels\Admin;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\Models\App;

class ShowAppViewModel extends ViewModel
{
    public function __construct(
        protected readonly ?Request $request = null,
        protected readonly ?App $app = null
    ) {
    }

    public function app()
    {
        $app = $this->app;

        $app->loadMissing([
            'features.feature',
            'plans.plan',
            'media',
        ]);

        return AppData::fromModel($app)->all();
    }
}
