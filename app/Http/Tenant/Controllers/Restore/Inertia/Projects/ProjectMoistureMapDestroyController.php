<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\DestroyProjectMoistureMapAction;
use SAAS\Domain\Restore\Models\MoistureMap;
use SAAS\Domain\Restore\Models\Project;

class ProjectMoistureMapDestroyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Project $project, MoistureMap $moistureMap)
    {
        $this->authorize('delete moisture map', $request->tenant());

        DestroyProjectMoistureMapAction::execute($project, $moistureMap);

        return redirect()->route('restore.projects.moisture-map.index', [$project]);
    }
}
