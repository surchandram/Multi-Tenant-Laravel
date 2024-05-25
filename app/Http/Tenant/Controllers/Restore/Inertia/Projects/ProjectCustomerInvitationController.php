<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\SendCustomerInvitationAction;
use SAAS\Domain\Restore\Models\Project;

class ProjectCustomerInvitationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Project $project)
    {
        $this->authorize('send customer invitation', $request->tenant());

        try {
            SendCustomerInvitationAction::execute(
                $project,
                $request->tenant()
            );
        } catch (\Exception $e) {
            Log::error('Failed sending invitation to customer.', [$e]);

            return back()->withError(__('tenant.project.customer_invitation_failed'));
        }

        return redirect()->route('restore.projects.show', $project)
            ->withSuccess(__('tenant.project.customer_invitation_sent'));
    }
}
