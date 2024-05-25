<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\ViewModels\ProjectReportSetupViewModel;

class ProjectReportSetupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Momentum\Modal\Modal
     */
    public function __invoke(Request $request, Project $project)
    {
        $this->authorize('export project report', $request->tenant());

        $model = new ProjectReportSetupViewModel($project);

        return inertia()
            ->modal('tenant/modals/restore/projects/reports/Setup', compact('model'))
            ->baseRoute('restore.projects.show', $project);
    }
}
