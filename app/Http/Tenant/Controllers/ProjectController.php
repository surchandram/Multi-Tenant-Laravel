<?php

namespace SAAS\Http\Tenant\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Tenant\Models\Project;

class ProjectController extends Controller
{
    /**
     * ProjectController constructor.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     **/
    public function __construct(Request $request)
    {
        $team = $request->tenant();

        $this->middleware(["team_plan.maxed:{$team},projects"])->only('create', 'store', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::withCount(['files'])->get();

        return view('tenant.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:tenant.projects,name']
        ]);

        $project = Project::create(['name' => $request->name]);

        return redirect()->route('tenant.projects.show', $project)
            ->withSuccess(__('Project created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Tenant\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $project->load(['files.user']);

        return view('tenant.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAAS\Domain\Tenant\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Tenant\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $project->update($request->only(['name', 'description']));

        return redirect()->back()->withSuccess(__('Project updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAAS\Domain\Tenant\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->back()->withSuccess(__('Project :project deleted.', ['project' => $project->name]));
    }
}
