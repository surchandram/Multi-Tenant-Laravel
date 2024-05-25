<?php

namespace SAAS\Domain\Tenant\ViewModels\CustomerPortal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Restore\DataTransferObjects\NewProjectsCountData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Shared\Filters\DateFilter;

class GetDashboardViewModel extends ViewModel
{
    public function __construct(
        private readonly ?Request $request = null,
    ) {
    }

    public function projectsCount()
    {
        return new NewProjectsCountData(
            total: Project::whereOwnedByUser(Auth::user())->count(),
            /** this month */
            this_month: Project::whereCreatedBetween(
                DateFilter::thisMonth()
            )->whereOwnedByUser(Auth::user())->count(),
            /** this week */
            this_week: Project::whereCreatedBetween(
                DateFilter::thisWeek()
            )->whereOwnedByUser(Auth::user())->count(),
            /** today */
            today: Project::whereCreatedBetween(
                DateFilter::today()
            )->whereOwnedByUser(Auth::user())->count(),
        );
    }

    public function projects()
    {
        return ProjectData::collection(
            Project::with([
                'address',
                'owner.address',
                'status',
            ])->whereOwnedByUser(Auth::user())->latest()->limit(5)->get()
        );
    }
}
