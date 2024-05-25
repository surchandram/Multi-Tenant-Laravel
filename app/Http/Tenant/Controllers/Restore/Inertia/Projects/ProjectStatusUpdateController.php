<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Http\Tenant\Requests\Projects\ProjectStatusUpdateRequest;

class ProjectStatusUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ProjectStatusUpdateRequest $request, Project $project)
    {
        $this->authorize('update project status', $request->tenant());

        $project = $request->updateStatus();

        if (! $project->wasChanged()) {
            return back()->withError(__('tenant.project.status_update_failed'));
        }

        return back()->withSuccess(__('tenant.project.status_updated'));
    }
}
