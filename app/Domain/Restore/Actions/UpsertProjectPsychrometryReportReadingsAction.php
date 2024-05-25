<?php

namespace SAAS\Domain\Restore\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use SAAS\Domain\Restore\DataTransferObjects\PsychrometryReportData;
use SAAS\Domain\Restore\Models\Project;
use Spatie\LaravelData\DataCollection;

class UpsertProjectPsychrometryReportReadingsAction
{
    /**
     * Update or create moisture maps readings.
     *
     * @param  DataCollection<PsychrometryReportData>  $readings
     */
    public static function execute($readings, Project $project): Project
    {
        try {
            DB::transaction(function () use ($readings, $project) {
                // loop through readings and 'create' or 'update' them
                $readings->each(
                    fn (PsychrometryReportData $psychrometryReportData) => $project
                        ->psychrometricReports()
                        ->updateOrCreate([
                            'project_id' => $project->id,
                            'project_affected_area_id' => $psychrometryReportData->affectedArea->id,
                            'psychrometry_measure_point_id' => $psychrometryReportData->psychrometryMeasurePoint->id,
                            'recorded_at' => Carbon::parse($psychrometryReportData->recorded_at),
                        ], [
                            'temperature' => $psychrometryReportData->temperature,
                            'relative_humidity' => $psychrometryReportData->relative_humidity,
                        ])
                );
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $project->fresh();
    }
}
