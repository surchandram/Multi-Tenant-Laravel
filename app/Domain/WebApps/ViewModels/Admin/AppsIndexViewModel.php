<?php

namespace SAAS\Domain\WebApps\ViewModels\Admin;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\Filters\AppFilters;
use SAAS\Domain\WebApps\Models\App;

class AppsIndexViewModel extends ViewModel
{
    public function __construct(
        protected readonly Request $request
    ) {
    }

    public function apps()
    {
        return AppData::collection(
            App::filter($this->request)
                ->withCount(['features', 'plans'])
                ->paginate()
        );
    }

    public function filters()
    {
        return AppFilters::mappings();
    }
}
