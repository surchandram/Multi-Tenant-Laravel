<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use Spatie\LaravelData\Data;

class ProjectClassData extends Data
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
}
