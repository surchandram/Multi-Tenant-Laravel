<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectLog;
use SAAS\Http\Tenant\Requests\Projects\ProjectLogDeleteRequest;
use SAAS\Http\Tenant\Requests\Projects\ProjectLogStoreRequest;
use SAAS\Http\Tenant\Requests\Projects\ProjectLogUpdateRequest;

class ProjectLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectLogStoreRequest $request, Project $project)
    {
        $this->authorize('post project log', $request->tenant());

        $request->storeProjectLog();

        return back()->withSuccess(__('tenant.project.log_created'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, ProjectLog $projectLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectLogUpdateRequest $request, Project $project, ProjectLog $projectLog)
    {
        $this->authorize('update project log', $request->tenant());

        $request->updateProjectLog();

        return back()->withSuccess(__('tenant.project.log_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectLogDeleteRequest $request, Project $project, ProjectLog $projectLog)
    {
        $this->authorize('delete project log', $request->tenant());

        $request->deleteLog();

        return back()->withSuccess(__('tenant.project.log_deleted'));
    }
}
