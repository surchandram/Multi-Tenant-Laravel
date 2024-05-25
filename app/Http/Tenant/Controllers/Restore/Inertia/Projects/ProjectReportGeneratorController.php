<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\ViewModels\ProjectReportViewModel;

class ProjectReportGeneratorController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Project $project)
    {
        $this->authorize('export project report', $request->tenant());

        $model = new ProjectReportViewModel($project, $request);

        $pdf = LaravelMpdf::chunkLoadView('<html-separator/>', 'tenant.projects.reports.work_report_mpdf', [
            'model' => $model->toArray(),
        ]);
        $pdf->h2toc = [
            'H1' => 0,
            'H2' => 1,
            'H3' => 2,
        ];
        $pdf->h2bookmarks = ['H1' => 0, 'H2' => 1, 'H3' => 2];

        return $pdf->stream($project->id.' - '.$project->name.'.pdf');
    }
}
