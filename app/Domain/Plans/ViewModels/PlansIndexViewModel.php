<?php

namespace SAAS\Domain\Plans\ViewModels;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Plans\DataTransferObjects\PlanData;
use SAAS\Domain\Plans\Models\Plan;

class PlansIndexViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Request $request = null,
    ) {
    }

    public function plans()
    {
        return PlanData::collection(
            Plan::withCount(['subscribers', 'teamSubscribers'])
                ->search($this->request->name)
                ->orderByDesc('created_at')
                ->paginate()
        );
    }

    public function filters()
    {
        return [];
    }
}
