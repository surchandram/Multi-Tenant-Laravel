<?php

namespace SAAS\Domain\Tenant\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Restore\DataTransferObjects\NewProjectsCountData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Shared\Filters\DateFilter;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class GetDashboardViewModel extends ViewModel
{
    /**
     * Get new projects count statistics.
     */
    public function newProjectsCount(): NewProjectsCountData
    {
        return new NewProjectsCountData(
            total: Project::count(),
            /** this month */
            this_month: Project::whereCreatedBetween(
                DateFilter::thisMonth()
            )->count(),
            /** this week */
            this_week: Project::whereCreatedBetween(
                DateFilter::thisWeek()
            )->count(),
            /** today */
            today: Project::whereCreatedBetween(
                DateFilter::today()
            )->count(),
        );
    }

    /**
     * Get all project regardless of status.
     */
    public function allProjects(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        $projects = Project::with([
            'owner:id,name',
            'address',
            'team:id,name,usable',
            'type:id,name,slug,usable',
            'status:id,name',
        ])
            ->limit(8)
            ->orderBy('created_at', 'desc')
            ->get();

        return ProjectData::collection($projects);
    }
}
