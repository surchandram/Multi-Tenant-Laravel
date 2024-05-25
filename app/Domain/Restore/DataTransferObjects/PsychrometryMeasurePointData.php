<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use SAAS\Domain\Restore\Models\PsychrometryMeasurePoint;
use Spatie\LaravelData\Data;

class PsychrometryMeasurePointData extends Data
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
        return self::fromModel(PsychrometryMeasurePoint::findOrFail($id));
    }

    public static function fromModel(PsychrometryMeasurePoint $psychrometryMeasurePoint): self
    {
        return self::from([
            ...$psychrometryMeasurePoint->toArray(),
        ]);
    }
}
