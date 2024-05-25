<?php

namespace SAAS\Domain\Companies\ViewModels;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\Models\App;

class CreateCompanyViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Request $request,
    ) {
    }

    public function apps()
    {
        return AppData::collection(
            App::with([
                'features.feature',
                'plans.plan' => fn ($query) => $query->active(),
            ])->active()->get()
        );
    }
}
