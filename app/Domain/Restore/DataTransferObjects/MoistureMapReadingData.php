<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use SAAS\Domain\Restore\Models\MoistureMapReading;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class MoistureMapReadingData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?float $value,
        public readonly ?string $recorded_at,
        public readonly null|Lazy|MoistureMapData $moistureMap,
    ) {
    }

    public static function fromModel(MoistureMapReading $moistureMapReading)
    {
        return self::from([
            ...$moistureMapReading->toArray(),
        ]);
    }
}
