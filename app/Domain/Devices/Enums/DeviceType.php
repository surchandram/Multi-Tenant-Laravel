<?php

namespace SAAS\Domain\Devices\Enums;

enum DeviceType: string
{
    case Sensor = 'sensor';
    case GPSTracker = 'gps_tracker';
    case BluetoothTracker = 'bluetooth_tracker';

    public function label(): string
    {
        return match ($this) {
            self::Sensor => 'Sensor',
            self::GPSTracker => 'GPS Tracker',
            self::BluetoothTracker => 'Bluetooth Tracker',
        };
    }
}
