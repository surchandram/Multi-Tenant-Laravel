<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\ViewModels\ProjectPsychrometricReportViewModel;

class PsychrometricReportIndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function __invoke(Request $request, Project $project)
    {
        $this->authorize('view project', $request->tenant());

        $model = new ProjectPsychrometricReportViewModel($project);

        return Inertia::render(
            'tenant/views/restore/projects/PsychrometricReport',
            compact('model')
        );
    }
}
