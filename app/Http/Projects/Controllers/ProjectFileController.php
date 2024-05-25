<?php

namespace SAAS\Http\Projects\Controllers;

use SAAS\App\Controllers\Controller;
use SAAS\Domain\Files\Models\File;
use SAAS\Domain\Projects\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \SAAS\Domain\Projects\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \SAAS\Domain\Projects\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Projects\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $upload = $request->file('file');

        $path = Storage::disk('user')->putFile("/projects/{$project->id}/", $upload);

        $file = File::make([
            'name' => $upload->getClientOriginalName(),
            'path' => $path,
        ]);

        $project->files()->save($file);

        return back()->withSuccess(
            __('File uploaded.')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Projects\Models\Project  $project
     * @param  \SAAS\Domain\Files\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAAS\Domain\Projects\Models\Project  $project
     * @param  \SAAS\Domain\Files\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Projects\Models\Project  $project
     * @param  \SAAS\Domain\Files\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAAS\Domain\Projects\Models\Project  $project
     * @param  \SAAS\Domain\Files\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, File $file)
    {
        //
    }
}
