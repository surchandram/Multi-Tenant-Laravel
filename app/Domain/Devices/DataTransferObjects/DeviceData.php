<?php

namespace SAAS\Domain\Devices\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Devices\Models\Device;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class DeviceData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $uuid,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $created_at,
        #[MapInputName('type_id')]
        public readonly null|Lazy|DeviceTypeData $type = null,
        public readonly bool $usable = false,
    ) {
    }

    public static function fromRequest(Request $request)
    {
        return self::from([
            ...$request->validated(),
            'type' => $request->validated('type_id') ? DeviceTypeData::fromId($request->type_id) : null,
        ]);
    }

    public static function fromModel(Device $device)
    {
        return self::from([
            ...$device->toArray(),
            'type' => Lazy::whenLoaded(
                'type', $device, fn () => DeviceTypeData::from($device->type)
            ),
        ]);
    }
}
