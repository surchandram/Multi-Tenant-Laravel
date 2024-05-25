<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Restore\Models\Project;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class MoistureMapData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly null|Lazy|ProjectData $project,
        /** @var DataCollection<StructureMoistureData> $mappedAreas */
        public readonly null|Lazy|DataCollection $mappedAreas,
    ) {
    }

    public static function fromRequest(Request $request, ?Project $project = null)
    {
        return self::from([
            ...$request->validated(),
            'project' => $project?->toArray(),
            'mappedAreas' => StructureMoistureData::collection(
                array_map(function ($data) use ($project) {
                    return StructureMoistureData::fromRequestData(
                        $project,
                        $data
                    );
                }, $request->moisture_map)
            ),
        ]);
    }
}
