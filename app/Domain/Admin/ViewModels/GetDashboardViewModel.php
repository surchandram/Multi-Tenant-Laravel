<?php

namespace SAAS\Domain\Admin\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Companies\DataTransferObjects\NewCompaniesCountData;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Payments\DataTransferObjects\PaymentsSummaryData;
use SAAS\Domain\Payments\Models\Payment;
use SAAS\Domain\Shared\Filters\DateFilter;
use SAAS\Domain\Users\DataTransferObjects\NewUsersCountData;
use SAAS\Domain\Users\Models\User;
use SAAS\Domain\WebApps\DataTransferObjects\AppsCountData;
use SAAS\Domain\WebApps\Models\App;

class GetDashboardViewModel extends ViewModel
{
    public function newUsersCount()
    {
        return new NewUsersCountData(
            total: User::count(),
            /** this month */
            this_month: User::whereJoinedBetween(
                DateFilter::thisMonth()
            )->count(),
            /** this week */
            this_week: User::whereJoinedBetween(
                DateFilter::thisWeek()
            )->count(),
            /** today */
            today: User::whereJoinedBetween(
                DateFilter::today()
            )->count(),
        );
    }

    public function newCompaniesCount()
    {
        return new NewCompaniesCountData(
            total: Company::count(),
            /** this month */
            this_month: Company::whereCreatedBetween(
                DateFilter::thisMonth()
            )->count(),
            /** this week */
            this_week: Company::whereCreatedBetween(
                DateFilter::thisWeek()
            )->count(),
            /** today */
            today: Company::whereCreatedBetween(
                DateFilter::today()
            )->count(),
        );
    }

    public function appsCount()
    {
        return new AppsCountData(
            total: App::count(),
            /** active */
            active: App::active()->count(),
        );
    }

    public function revenue()
    {
        return new PaymentsSummaryData(
            lifetime: Payment::sum('subtotal'),
            /** this month */
            this_month: Payment::whereCreatedBetween(
                DateFilter::thisMonth()
            )->sum('subtotal'),
            /** this week */
            this_week: Payment::whereCreatedBetween(
                DateFilter::thisWeek()
            )->sum('subtotal'),
            /** today */
            today: Payment::whereCreatedBetween(
                DateFilter::today()
            )->sum('subtotal'),
        );
    }

    public function companies()
    {
        return CompanyData::collection(
            Company::with([
                'addresses.country',
                'subscriptions.items',
            ])->latest('created_at')->limit(10)->get()
        );
    }
}
