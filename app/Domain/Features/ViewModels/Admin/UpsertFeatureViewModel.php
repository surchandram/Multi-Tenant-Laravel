<?php

namespace SAAS\Domain\Features\ViewModels\Admin;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Features\DataTransferObjects\FeatureData;
use SAAS\Domain\Features\Models\Feature;

class UpsertFeatureViewModel extends ViewModel
{
    public function __construct(
        public readonly Feature $feature,
    ) {
    }

    public function feature()
    {
        return FeatureData::fromModel($this->feature);
    }
}
