<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use Spatie\LaravelData\Data;

class StructureData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $slug,
        public readonly ?string $description,
        public readonly ?string $created_at,
        public readonly bool $usable = true,
    ) {
    }

    public static function fromString(string $name)
    {
        return self::from(['name' => $name]);
    }
}
