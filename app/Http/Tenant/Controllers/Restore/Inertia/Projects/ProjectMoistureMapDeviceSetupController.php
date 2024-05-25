<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use SAAS\App\Controllers\Controller;
use SAAS\Domain\Devices\DataTransferObjects\DeviceData;
use SAAS\Domain\Restore\Actions\SetupMoistureMapDeviceAction;
use SAAS\Domain\Restore\Models\MoistureMap;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Http\Tenant\Requests\Projects\ProjectMoistureMapDeviceStoreRequest;

class ProjectMoistureMapDeviceSetupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ProjectMoistureMapDeviceStoreRequest $request, Project $project, MoistureMap $moistureMap)
    {
        $this->authorize('setup moisture map sensors', $request->tenant());

        $moistureMap = SetupMoistureMapDeviceAction::execute(
            DeviceData::fromRequest($request),
            $moistureMap
        );

        return redirect()->route('restore.projects.moisture-map.index', $project)
            ->withSuccess(
                __('Device setup for :area :structure :material successful.', [
                    'area' => $moistureMap->affectedArea->affectedArea->name,
                    'structure' => $moistureMap->structure->name,
                    'material' => $moistureMap->material->name,
                ])
            );
    }
}
