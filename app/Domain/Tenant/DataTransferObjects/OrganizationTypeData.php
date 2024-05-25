<?php

namespace SAAS\Domain\Tenant\DataTransferObjects;

use SAAS\Domain\Tenant\Models\OrganizationType;
use Spatie\LaravelData\Data;

class OrganizationTypeData extends Data
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

    public static function fromString(string $slug): self
    {
        $type = OrganizationType::firstOrNew(['slug' => $slug]);

        return self::fromModel($type);
    }

    public static function fromModel(OrganizationType $organizationType): self
    {
        return self::from([
            ...$organizationType->toArray(),
        ]);
    }
}
