<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ProjectAuthorizationStoreRequest $request, Project $project)
    {
        $this->authorize('handle project authorization', $request->tenant());

        try {
            AuthorizeProjectAction::execute(
                $request->validated('documents'),
                $project,
                $request->tenant()
            );
        } catch (\Exception $e) {
            Log::error('Failed authorizing project.', [$e]);

            return back()->withErrors([
                'general' => __('tenant.project.authorization_failed'),
                config('app.debug', false) ? Arr::flatten(['debug' => $e->getMessage()]) : null,
            ])->withError(__('tenant.project.authorization_failed'));
        }

        return redirect()->route('restore.projects.show', $project)->withSuccess(
            __('tenant.project.authorization_succeeded')
        );
    }
}
