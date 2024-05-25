<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Devices\Actions\UpsertDeviceAction;
use SAAS\Domain\Restore\DataTransferObjects\PsychrometryDeviceMapData;
use SAAS\Domain\Restore\Models\PsychrometryDeviceMap;

class SetupPsychrometryReportDeviceAction
{
    /**
     * Store or update psychrometry report affected area device.
     */
    public static function execute(PsychrometryDeviceMapData $psychrometryDeviceMapData): PsychrometryDeviceMap
    {
        try {
            $model = DB::transaction(function () use ($psychrometryDeviceMapData) {
                $device = UpsertDeviceAction::execute(
                    $psychrometryDeviceMapData->device
                );

                $psychrometryDeviceMap = PsychrometryDeviceMap::firstOrNew([
                    'project_id' => $psychrometryDeviceMapData->project->id,
                    'psychrometry_measure_point_id' => $psychrometryDeviceMapData->psychrometryMeasurePoint->id,
                    'project_affected_area_id' => $psychrometryDeviceMapData->affectedArea->id,
                ], [
                    'device_id' => $device->id,
                ]);

                $psychrometryDeviceMap->save();

                return $psychrometryDeviceMap;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $model;
    }
}
