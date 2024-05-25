<?php

namespace SAAS\Http\Tenant\Controllers\Customers\Projects;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Tenant\ViewModels\CustomerPortal\Projects\ShowProjectViewModel;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($tenant, Project $project)
    {
        $model = new ShowProjectViewModel($project);

        return Inertia::render('tenant/views/customers/portal/projects/Show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
