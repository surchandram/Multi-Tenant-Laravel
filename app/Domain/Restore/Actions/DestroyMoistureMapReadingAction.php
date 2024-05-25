<?php

namespace SAAS\Domain\Restore\Actions;

use SAAS\Domain\Restore\Models\MoistureMap;
use SAAS\Domain\Restore\Models\MoistureMapReading;

class DestroyMoistureMapReadingAction
{
    public static function execute(MoistureMap $moistureMap, MoistureMapReading $moistureMapReading): MoistureMap
    {
        try {
            $moistureMap->readings()->where('id', $moistureMapReading->id)->delete();
        } catch (\Exception $e) {
            throw $e;
        }

        return $moistureMap->fresh();
    }
}
