<?php

namespace SAAS\Domain\Devices\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Devices\DataTransferObjects\DeviceData;
use SAAS\Domain\Devices\Models\Device;

class UpsertDeviceAction
{
    public static function execute(DeviceData $deviceData): Device
    {
        try {
            $device = DB::transaction(function () use ($deviceData) {
                $data = [
                    'name' => $deviceData->name,
                    'type_id' => $deviceData->type == null ? null : $deviceData->type?->id,
                    'usable' => true,
                ];

                return Device::updateOrCreate([
                    'name' => $deviceData->name,
                ], $data);
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $device;
    }
}
