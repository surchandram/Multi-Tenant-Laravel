<?php

namespace SAAS\Domain\Restore\ViewModels;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;

class ProjectsIndexViewModel extends ViewModel
{
    public function __construct(
        public readonly Request $request
    ) {
    }

    public function projects()
    {
        return ProjectData::collection(
            Project::filter($this->request)->with([
                'status',
                'type',
                'class',
                'category',
                'team',
                'address.country',
                'owner',
            ])->withCount([
                'affectedAreas',
            ])->paginate(),
        );
    }

    public function filters()
    {
        return [];
    }
}
