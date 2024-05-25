<?php

namespace SAAS\Domain\WebApps\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\Models\App;

class GetRoutableAppsViewModel extends ViewModel
{
    public function apps()
    {
        return AppData::collection(
            App::active()->get()
        );
    }
}
