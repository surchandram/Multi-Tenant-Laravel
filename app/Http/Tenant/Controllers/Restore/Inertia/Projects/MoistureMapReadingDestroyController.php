<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\DestroyMoistureMapReadingAction;
use SAAS\Domain\Restore\Models\MoistureMap;
use SAAS\Domain\Restore\Models\MoistureMapReading;

class MoistureMapReadingDestroyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, MoistureMap $moistureMap, MoistureMapReading $reading)
    {
        $this->authorize('adjust moisture map readings', $request->tenant());

        try {
            DestroyMoistureMapReadingAction::execute(
                $moistureMap,
                $reading
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return redirect()->route('restore.projects.moisture-map.index', $moistureMap->project)
                ->withError(__('Failed delete reading.'));
        }

        return redirect()->route('restore.projects.moisture-map.index', $moistureMap->project)
            ->withSuccess(__('Reading removed from map successfully.'));
    }
}
