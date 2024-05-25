<?php

namespace Database\Seeders\Restore;

use Illuminate\Database\Seeder;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\PsychrometryMeasurePoint;
use SAAS\Domain\Restore\Models\PsychrometryReport;

class PsychrometryReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $measurePoints = PsychrometryMeasurePoint::active()->get();
        // project
        // psy report
        // date
        // affected_area
        // measure point
        // temp
        // RH
        // GPP
        // Dew

        Project::query()->each(
            fn (Project $project) => $this->buildProjectPsychrometryReport($project, $measurePoints)
        );
    }

    protected function buildProjectPsychrometryReport(Project $project, $measurePoints)
    {
        if (! filled($project->starts_at)) {
            return;
        }

        if (! filled($project->ends_at)) {
            return;
        }

        $inspectionDates = [];

        $startedAt = $project->starts_at;
        $inspectionDates[] = $startedAt->format('Y-m-d');

        do {
            $startedAt = $startedAt->addDay();

            // add date if next date is less than project end date
            if ($startedAt->lt($project->ends_at)) {
                $inspectionDates[] = $startedAt->format('Y-m-d');
            }
        } while ($startedAt->lte($project->ends_at));

        foreach ($inspectionDates as $recordedAt) {

            /** @var \Illuminate\Support\Collection<\SAAS\Domain\Restore\Models\ProjectAffectedArea> $affectedAreas */
            $affectedAreas = $project->affectedAreas;

            // create area's report
            foreach ($affectedAreas as $affectedArea) {
                // loop through psychrometry measure points
                foreach ($measurePoints as $model) {
                    $report = PsychrometryReport::factory()
                        ->make($attributes = [
                            'project_id' => $project->id,
                            'project_affected_area_id' => $affectedArea->id,
                            'psychrometry_measure_point_id' => $model->id,
                            'recorded_at' => $recordedAt,
                        ]);

                    $project->psychrometricReports()
                        ->where('recorded_at', '<', $project->starts_at)
                        ->orWhere('recorded_at', '>', $project->ends_at)
                        ->delete();

                    $project->psychrometricReports()->firstOrCreate(
                        $attributes,
                        $report->getAttributes()
                    );
                }
            }
        }
    }
}
