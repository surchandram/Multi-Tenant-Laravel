<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Support\Facades\Log;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\SetupPsychrometryReportDeviceAction;
use SAAS\Domain\Restore\DataTransferObjects\PsychrometryDeviceMapData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Http\Tenant\Requests\Projects\PsychrometricReportDeviceStoreRequest;

class PsychrometricReportDeviceSetupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PsychrometricReportDeviceStoreRequest $request, Project $project)
    {
        $this->authorize('setup psychrometric report sensors', $request->tenant());

        try {
            SetupPsychrometryReportDeviceAction::execute(
                PsychrometryDeviceMapData::fromRequest($request)
            );
        } catch (\Exception $e) {
            Log::error('Failed setting up psychrometric report device.', [$e]);

            return redirect()->route('restore.projects.psychrometric-report.index', $project)
                ->withErrors([
                    'device' => __('Failed linking device.'),
                ]);
        }

        return redirect()->route('restore.projects.psychrometric-report.index', $project)
            ->withSuccess(__('Device linked successfully.'));
    }
}
