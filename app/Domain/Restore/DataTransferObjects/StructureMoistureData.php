<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Devices\DataTransferObjects\DeviceData;
use SAAS\Domain\Restore\Models\MoistureMap;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectAffectedArea;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class StructureMoistureData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ProjectAffectedAreaData $affectedArea,
        public readonly StructureData $structure,
        public readonly MaterialData $material,
        public readonly ?DeviceData $device,
        /** @var DataCollection<MoistureMapReadingData> */
        public readonly null|Lazy|DataCollection $readings,
    ) {
    }

    public static function fromRequest(Request $request)
    {
        return self::from([
            'affectedArea' => ProjectAffectedAreaData::fromModel(
                ProjectAffectedArea::where(
                    'project_id',
                    $request->project
                )->where(
                    'affected_area_id',
                    $request->affected_area_id,
                )->first()
            ),
            'structure' => StructureData::fromString(
                $request->structure
            ),
            'material' => MaterialData::fromString(
                $request->material
            ),
            'readings' => ($readings = $request->validated('readings')) ? MoistureMapReadingData::collection(
                $readings
            ) : null,
        ]);
    }

    public static function fromModel(MoistureMap $moistureMap)
    {
        return self::from([
            ...$moistureMap->toArray(),
            'affectedArea' => ProjectAffectedAreaData::from(
                $moistureMap->affectedArea
            ),
            'structure' => StructureData::from(
                $moistureMap->structure
            ),
            'material' => MaterialData::from(
                $moistureMap->material
            ),
            'device' => ! empty($moistureMap->device_id) ? DeviceData::fromModel(
                $moistureMap->device
            ) : null,
            'readings' => MoistureMapReadingData::collection(
                $moistureMap->readings
            ),
        ]);
    }

    public static function fromRequestData(Project $project, array $data)
    {
        return self::from([
            'affectedArea' => ProjectAffectedAreaData::fromModel(
                ProjectAffectedArea::where(
                    'project_id',
                    $project->id
                )->where(
                    'affected_area_id',
                    $data['affected_area_id'],
                )->first()
            ),
            'structure' => StructureData::fromString(
                $data['structure']
            ),
            'material' => MaterialData::fromString(
                $data['material']
            ),
        ]);
    }
}
