<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Support\Facades\Log;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\UpsertProjectPsychrometryReportReadingsAction;
use SAAS\Domain\Restore\DataTransferObjects\PsychrometryReportData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Http\Tenant\Requests\Projects\ProjectPsychrometricReportReadingsStoreRequest;

class PsychrometricReportReadingsStoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ProjectPsychrometricReportReadingsStoreRequest $request, Project $project)
    {
        $this->authorize('adjust psychrometric report readings', $request->tenant());

        try {
            UpsertProjectPsychrometryReportReadingsAction::execute(
                PsychrometryReportData::collection(
                    $request->validated('psychrometric_report')
                ),
                $project,
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return redirect()
                ->route('restore.projects.psychrometric-report.index', $project)
                ->withErrors([
                    'general' => $e->getMessage(),
                ])
                ->withError($e->getMessage());
        }

        return redirect()
            ->route('restore.projects.psychrometric-report.index', $project)
            ->withSuccess(__('Psychrometric report updated successfully.'));
    }
}
