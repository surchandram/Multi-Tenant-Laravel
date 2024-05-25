<?php

namespace SAAS\Domain\Devices\DataTransferObjects;

use SAAS\Domain\Devices\Models\DeviceType;
use Spatie\LaravelData\Data;

class DeviceTypeData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $slug,
        public readonly ?string $description,
        public readonly ?string $created_at,
        public readonly bool $usable = false,
    ) {
    }

    public static function fromId(int $id): self
    {
        return self::fromModel(DeviceType::find($id));
    }

    public static function fromModel(DeviceType $deviceType): self
    {
        return self::from([
            ...$deviceType->toArray(),
        ]);
    }
}
