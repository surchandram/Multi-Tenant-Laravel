<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\ViewModels\ShowProjectViewModel;

class ProjectAuthorizationIndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Momentum\Modal\Modal
     */
    public function __invoke(Request $request, Project $project)
    {
        $this->authorize('handle project authorization', $request->tenant());

        $model = new ShowProjectViewModel($project, $request);

        return inertia()
            ->modal('tenant/modals/restore/projects/authorization/CollectSignature', compact('model'))
            ->baseRoute('restore.projects.show', $project);
    }
}
