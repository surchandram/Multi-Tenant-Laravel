<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\UpsertProjectMoistureMapReadingsAction;
use SAAS\Domain\Restore\DataTransferObjects\MoistureMapReadingData;
use SAAS\Domain\Restore\Models\MoistureMap;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Http\Tenant\Requests\Projects\ProjectMoistureMapReadingsStoreRequest;

class ProjectMoistureMapReadingsStoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ProjectMoistureMapReadingsStoreRequest $request, Project $project, MoistureMap $moistureMap)
    {
        $this->authorize('adjust moisture map readings', $request->tenant());

        try {
            UpsertProjectMoistureMapReadingsAction::execute(
                MoistureMapReadingData::collection(
                    $request->validated('readings')
                ),
                $project,
                $moistureMap
            );
        } catch (\Exception $e) {
            return redirect()
                ->route('restore.projects.moisture-map.index', $project)
                ->withErrors([
                    'general' => $e->getMessage(),
                ])
                ->withError($e->getMessage());
        }

        return redirect()
            ->route('restore.projects.moisture-map.index', $project)
            ->withSuccess(
                __(
                    ':area :structure :material readings updated',
                    [
                        'area' => $moistureMap->affectedArea->affectedArea->name,
                        'structure' => $moistureMap->structure->name,
                        'material' => $moistureMap->material->name,
                    ]
                )
            );
    }
}
