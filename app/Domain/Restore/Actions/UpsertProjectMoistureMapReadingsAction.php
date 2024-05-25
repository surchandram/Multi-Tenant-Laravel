<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Restore\DataTransferObjects\MoistureMapReadingData;
use SAAS\Domain\Restore\Models\MoistureMap;
use SAAS\Domain\Restore\Models\Project;
use Spatie\LaravelData\DataCollection;

class UpsertProjectMoistureMapReadingsAction
{
    /**
     * Update or create moisture maps readings.
     *
     * @param  DataCollection<MoistureMapReadingData>  $structureMoistureData
     */
    public static function execute($readings, Project $project, MoistureMap $moistureMap): MoistureMap
    {
        try {
            DB::transaction(function () use ($readings, $moistureMap) {
                $readings->each(
                    fn (MoistureMapReadingData $moistureMapReadingData) => $moistureMap
                        ->readings()
                        ->updateOrCreate([
                            'recorded_at' => $moistureMapReadingData->recorded_at,
                        ], [
                            'value' => $moistureMapReadingData->value,
                        ])
                );
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $moistureMap;
    }
}
