<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Devices\DataTransferObjects\DeviceData;
use SAAS\Domain\Devices\Models\Device;
use SAAS\Domain\Devices\Models\DeviceType;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectAffectedArea;
use SAAS\Domain\Restore\Models\PsychrometryDeviceMap;
use SAAS\Domain\Restore\Models\PsychrometryMeasurePoint;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class PsychrometryDeviceMapData extends Data
{
    public function __construct(
        public readonly ?int $id,
        #[MapInputName('device')]
        public readonly null|Lazy|DeviceData $device,
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
        return self::fromModel(PsychrometryDeviceMap::find($id));
    }

    public static function fromModel(PsychrometryDeviceMap $psychrometryDeviceMap): self
    {
        return self::from([
            ...$psychrometryDeviceMap->toArray(),
            'device' => Lazy::whenLoaded(
                'device',
                $psychrometryDeviceMap,
                fn () => DeviceData::from($psychrometryDeviceMap->device)
            ),
            'project' => Lazy::whenLoaded(
                'project',
                $psychrometryDeviceMap,
                fn () => ProjectData::from($psychrometryDeviceMap->project)
            ),
            'affectedArea' => ProjectAffectedAreaData::from($psychrometryDeviceMap->affectedArea),
            'psychrometryMeasurePoint' => Lazy::whenLoaded(
                'project',
                $psychrometryDeviceMap,
                fn () => PsychrometryMeasurePointData::from($psychrometryDeviceMap->psychrometryMeasurePoint)
            ),
        ]);
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
            'device' => DeviceData::fromModel(
                Device::firstOrNew([
                    'name' => $request->device,
                    'type_id' => DeviceType::find($request->type_id),
                ])
            ),
            'project' => ProjectData::fromModel(
                $request->project
            ),
            'affectedArea' => ProjectAffectedAreaData::from(
                ProjectAffectedArea::find($request->project_affected_area_id)->first()
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
            $startedAt = $startedAt->addDay();
            $inspectionDates[] = $startedAt->format('Y-m-d');
        } while ($startedAt->lt($project->ends_at));

        // loop through dates
        foreach ($inspectionDates as $recordedAt) {

            /** @var \Illuminate\Support\Collection<SAAS\Domain\Restore\Models\ProjectAffectedArea> $affectedAreas */
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
}
