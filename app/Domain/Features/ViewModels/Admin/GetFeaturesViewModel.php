<?php

namespace SAAS\Domain\Features\ViewModels\Admin;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Features\DataTransferObjects\FeatureData;
use SAAS\Domain\Features\Models\Feature;

class GetFeaturesViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Request $request = null,
    ) {
    }

    public function features()
    {
        return FeatureData::collection(
            Feature::orderByDesc('created_at')->paginate(25)
        );
    }
}
