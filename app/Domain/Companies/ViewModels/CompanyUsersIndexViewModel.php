<?php

namespace SAAS\Domain\Companies\ViewModels;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\DataTransferObjects\CompanyUserData;
use SAAS\Domain\Companies\Models\Company;

class CompanyUsersIndexViewModel extends ViewModel
{
    public function __construct(
        public readonly Request $request,
        public readonly Company $company,
    ) {
    }

    public function company()
    {
        return CompanyData::from($this->company);
    }

    public function users()
    {
        return CompanyUserData::collection(
            $this->company->users()->with([
                'roles' => function ($query) {
                    $query->where('permitable_id', $this->company->id)
                        ->orWhereHasMorph('roleable', Company::class, function ($query) {
                            $query->where('id', $this->company->id);
                        })
                        ->active()
                        ->wherePivotNull('expires_at')
                        ->orderByPivot('created_at', 'desc');
                },
            ])->orderByPivot('created_at')->paginate()
        );
    }

    public function filters()
    {
        return [];
    }
}
