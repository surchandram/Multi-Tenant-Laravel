<?php

namespace SAAS\Domain\Restore\ViewModels;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\DataTransferObjects\PsychrometryReportData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\PsychrometryMeasurePoint;

class ProjectPsychrometricReportViewModel extends ViewModel
{
    use ProjectsShareableTrait;

    public function __construct(
        public readonly ?Project $project,
        public readonly ?Request $request = null,
    ) {
        $this->project->loadMissing([
            'status',
            'affectedAreas.affectedArea',
            'psychrometricReports.affectedArea.affectedArea',
            'psychrometricReports.psychrometryMeasurePoint',
            // 'psychrometricReports.device',
        ]);
    }

    public function psychrometricReport()
    {
        return $this->project->psychrometricReports->asDateTree();
    }

    public function psychrometricReportSkeleton()
    {
        return PsychrometryReportData::reportSkeleton(
            $this->project,
            PsychrometryMeasurePoint::active()->get()
        );
    }

    public function deviceMap()
    {
        return PsychrometryReportData::deviceMap(
            $this->project,
            PsychrometryMeasurePoint::active()->get()
        );
    }

    public function project()
    {
        return ProjectData::fromModel($this->project);
    }
}
