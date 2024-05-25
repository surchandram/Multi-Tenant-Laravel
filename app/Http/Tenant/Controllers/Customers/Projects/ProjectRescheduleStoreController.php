<?php

namespace SAAS\Http\Tenant\Controllers\Customers\Projects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\RescheduleProjectAction;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Http\Tenant\Requests\Projects\RescheduleProjectStoreRequest;

class ProjectRescheduleStoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Miracuthbert\Multitenancy\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RescheduleProjectStoreRequest $request, $tenant, Project $project)
    {
        try {
            $project = RescheduleProjectAction::execute(ProjectData::fromRequest($request), $project);
        } catch (\Throwable $e) {
            Log::error('Failed rescheduling project.', [$e]);

            return back()->withErrors([
                'starts_at' => __('Failed rescheduling project.'),
            ]);
        }

        return redirect()->route('tenant.customers.portal.projects.show', $project)
            ->withInfo(__('Changes saved. Please await confirmation.'));
    }
}
