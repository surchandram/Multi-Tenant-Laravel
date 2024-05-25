<?php

namespace SAAS\Http\Tenant\Controllers\Customers\Projects;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\AuthorizeProjectAction;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Http\Tenant\Requests\Projects\ProjectAuthorizationStoreRequest;

class ProjectAuthorizationStoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Miracuthbert\Multitenancy\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ProjectAuthorizationStoreRequest $request, $tenant, Project $project)
    {
        try {
            AuthorizeProjectAction::execute(
                $request->validated('documents'),
                $project,
                $tenant
            );
        } catch (\Exception $e) {
            Log::error('Failed authorizing project.', [$e]);

            return back()->withErrors([
                'general' => __('customer.project.authorization_failed'),
                config('app.debug', false) ? Arr::flatten(['debug' => $e->getMessage()]) : null,
            ])->withError(__('customer.project.authorization_failed'));
        }

        return redirect()->route('tenant.customers.portal.projects.show', $project)->withSuccess(
            __('customer.project.authorization_succeeded')
        );
    }
}
