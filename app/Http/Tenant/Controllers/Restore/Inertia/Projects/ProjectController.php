<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\CreateProjectAction;
use SAAS\Domain\Restore\Actions\UpdateProjectAction;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\ViewModels\ProjectCreateViewModel;
use SAAS\Domain\Restore\ViewModels\ProjectEditViewModel;
use SAAS\Domain\Restore\ViewModels\ProjectsIndexViewModel;
use SAAS\Domain\Restore\ViewModels\ShowProjectViewModel;
use SAAS\Http\Tenant\Requests\Projects\ProjectStoreRequest;

class ProjectController extends Controller
{
    /**
     * ProjectController constructor.
     *
     * @return void
     **/
    public function __construct(Request $request)
    {
        $team = $request->tenant();

        // $this->middleware(["team_plan.maxed:{$team},projects"])->only('create', 'store', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('browse projects', $request->tenant());

        $model = new ProjectsIndexViewModel($request);

        return Inertia::render(
            'tenant/views/restore/projects/Index',
            compact('model')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create project', $request->tenant());

        $model = new ProjectCreateViewModel();

        return Inertia::render(
            'tenant/views/restore/projects/Create',
            compact('model')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectStoreRequest $request)
    {
        $project = CreateProjectAction::execute(
            ProjectData::fromRequest($request)
        );

        return redirect()->route('restore.projects.show', $project)
            ->withSuccess(
                __('Project :name created.', ['name' => $project->name])
            );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function show(Request $request, Project $project)
    {
        $this->authorize('view project', $request->tenant());

        $model = new ShowProjectViewModel($project);

        return Inertia::render(
            'tenant/views/restore/projects/Show',
            compact('model')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function edit(Request $request, Project $project)
    {
        $this->authorize('update project', $request->tenant());

        $model = new ProjectEditViewModel($project);

        return Inertia::render(
            'tenant/views/restore/projects/Edit',
            compact('model')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectStoreRequest $request, Project $project)
    {
        $this->authorize('update project', $request->tenant());

        UpdateProjectAction::execute(
            ProjectData::fromRequest($request),
            $project
        );

        return redirect()->route('restore.projects.show', $project)
            ->withSuccess(__('Project updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Project $project)
    {
        $this->authorize('delete project', $request->tenant());

        $project->delete();

        return redirect()->back()->withSuccess(__('Project :project deleted.', ['project' => $project->name]));
    }
}
