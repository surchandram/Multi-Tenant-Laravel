<?php

namespace SAAS\Domain\Teams\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Teams\DataTransferObjects\TeamData;
use SAAS\Domain\Teams\Models\Team;

class ShowTeamViewModel extends ViewModel
{
    public function __construct(
        public readonly Company $company,
        public readonly Team $team,
    ) {
    }

    public function company()
    {
        return CompanyData::from($this->company);
    }

    public function team()
    {
        return TeamData::from($this->team);
    }
}
