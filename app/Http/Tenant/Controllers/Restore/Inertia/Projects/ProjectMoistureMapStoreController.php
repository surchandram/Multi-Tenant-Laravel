<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\UpsertProjectMoistureMapAction;
use SAAS\Domain\Restore\DataTransferObjects\MoistureMapData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Http\Tenant\Requests\Projects\ProjectMoistureMapStoreRequest;

class ProjectMoistureMapStoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ProjectMoistureMapStoreRequest $request, Project $project)
    {
        $this->authorize('setup moisture map', $request->tenant());

        $moistureMapData = MoistureMapData::fromRequest(
            $request, $project
        );

        UpsertProjectMoistureMapAction::execute(
            $moistureMapData, $project
        );

        return redirect()
            ->route('restore.projects.moisture-map.index', $project)
            ->withSuccess(__('Project Moisture Map saved.'));
    }
}
