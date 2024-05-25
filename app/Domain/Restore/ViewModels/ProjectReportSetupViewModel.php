<?php

namespace SAAS\Domain\Restore\ViewModels;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;

class ProjectReportSetupViewModel extends ViewModel
{
    use ProjectsShareableTrait;

    public function __construct(
        public readonly ?Project $project,
        public readonly ?Request $request = null,
    ) {
        $this->project->loadMissing([
            'status',
            'type',
        ]);
    }

    public function defaults()
    {
        return [
            'insurance_summary',
            'moisture_map',
            'psychrometric_report',
        ];
    }

    public function config()
    {
        return ProjectData::reportSetupMap();
    }

    public function company()
    {
        $tenant = request()->tenant();

        tenancy()->runNonTenantTask(function () use (&$tenant) {
            $tenant->loadMissing([
                'addresses.country',
                'media',
            ]);
        });

        return CompanyData::fromModel($tenant);
    }

    public function project()
    {
        $project = $this->project;

        return ProjectData::fromModel($project);
    }
}
