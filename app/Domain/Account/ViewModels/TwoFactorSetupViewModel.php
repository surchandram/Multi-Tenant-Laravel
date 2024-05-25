<?php

namespace SAAS\Domain\Account\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Countries\DataTransferObjects\CountryData;
use SAAS\Domain\Countries\Models\Country;

class TwoFactorSetupViewModel extends ViewModel
{
    public function countries()
    {
        return CountryData::collection(Country::get());
    }
}
