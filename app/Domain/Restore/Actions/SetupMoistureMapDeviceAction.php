<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Devices\Actions\UpsertDeviceAction;
use SAAS\Domain\Devices\DataTransferObjects\DeviceData;
use SAAS\Domain\Restore\Models\MoistureMap;

class SetupMoistureMapDeviceAction
{
    /**
     * Store or update project's affected areas.
     */
    public static function execute(DeviceData $deviceData, MoistureMap $moistureMap): MoistureMap
    {
        try {
            DB::transaction(function () use ($deviceData, $moistureMap) {
                $device = UpsertDeviceAction::execute(
                    $deviceData
                );

                return $moistureMap->device()->associate($device)->save();
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $moistureMap->refresh();
    }
}
