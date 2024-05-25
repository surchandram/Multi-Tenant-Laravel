<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Devices\DataTransferObjects\DeviceData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectAffectedArea;
use SAAS\Domain\Restore\Models\PsychrometryMeasurePoint;
use SAAS\Domain\Restore\Models\PsychrometryReport;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class PsychrometryReportData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?float $temperature,
        public readonly ?float $relative_humidity,
        public readonly ?string $recorded_at,
        #[MapInputName('project_id')]
        public readonly null|Lazy|ProjectData $project,
        #[MapInputName('project_affected_area_id')]
        public readonly null|Lazy|ProjectAffectedAreaData $affectedArea,
        #[MapInputName('psychrometry_measure_point_id')]
        public readonly null|Lazy|PsychrometryMeasurePointData $psychrometryMeasurePoint,
    ) {
    }

    public static function fromId(int $id): self
    {
        return self::fromModel(PsychrometryReport::find($id));
    }

    public static function fromModel(PsychrometryReport $psychrometryReport): self
    {
        return self::from([
            ...$psychrometryReport->toArray(),
            'project' => Lazy::whenLoaded(
                'project',
                $psychrometryReport,
                fn () => ProjectData::from($psychrometryReport->project)
            ),
            'affectedArea' => ProjectAffectedAreaData::from($psychrometryReport->affectedArea),
            'psychrometryMeasurePoint' => Lazy::whenLoaded(
                'project',
                $psychrometryReport,
                fn () => PsychrometryMeasurePointData::from($psychrometryReport->psychrometryMeasurePoint)
            ),
        ]);
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
            'affectedArea' => ProjectAffectedAreaData::from(
                ProjectAffectedArea::where(
                    'affected_area_id', $request->affected_area_id
                )->where(
                    'project_id', $request->project
                )->first()
            ),
            'psychrometryMeasurePoint' => PsychrometryMeasurePointData::from(
                PsychrometryMeasurePoint::find($request->psychrometry_measure_point_id)
            ),
        ]);
    }

    public static function reportSkeleton(Project $project, $measurePoints)
    {
        $inspectionDates = [];
        $report = [];

        $startedAt = $project->starts_at;
        $inspectionDates[] = $startedAt->format('Y-m-d');

        do {
            $startedAt = $startedAt->copy()->addDay();

            // add date if next date is less than project end date
            if ($startedAt->lt($project->ends_at)) {
                $inspectionDates[] = $startedAt->format('Y-m-d');
            }
        } while ($startedAt->lt($project->ends_at));

        // loop through dates
        foreach ($inspectionDates as $recordedAt) {

            /** @var \Illuminate\Support\Collection<\SAAS\Domain\Restore\Models\ProjectAffectedArea> $affectedAreas */
            $affectedAreas = $project->affectedAreas;

            // create area's report
            foreach ($affectedAreas as $affectedArea) {
                // loop through psychrometry measure points
                foreach ($measurePoints as $model) {
                    $report[$recordedAt][$affectedArea->affectedArea->name][$model->name] = [
                        'project_id' => $project->id,
                        'project_affected_area_id' => $affectedArea->id,
                        'psychrometry_measure_point_id' => $model->id,
                        'recorded_at' => $recordedAt,
                        'temperature' => null,
                        'relative_humidity' => null,
                    ];
                }
            }
        }

        return $report;
    }

    public static function deviceMap(Project $project, $measurePoints)
    {
        $report = [];

        $project->loadMissing([
            'affectedAreas.affectedArea',
            'psychrometricReportDevices.device',
        ]);

        /** @var \Illuminate\Support\Collection<\SAAS\Domain\Restore\Models\ProjectAffectedArea> $affectedAreas */
        $affectedAreas = $project->affectedAreas;

        // create area's report
        foreach ($affectedAreas as $affectedArea) {
            // loop through psychrometry measure points
            foreach ($measurePoints as $model) {
                $device = transform($project->psychrometricReportDevices
                    ->where('project_affected_area_id', $affectedArea->id)
                    ->where('psychrometry_measure_point_id', $model->id)
                    ->first(),
                    fn ($psychrometryDeviceMap) => ! empty($psychrometryDeviceMap) ? DeviceData::fromModel($psychrometryDeviceMap->device) : null
                );

                $report[$affectedArea->affectedArea->name][$model->name] = [
                    'project_id' => $project->id,
                    'project_affected_area_id' => $affectedArea->id,
                    'psychrometry_measure_point_id' => $model->id,
                    'device' => $device,
                ];
            }
        }

        return $report;
    }
}
