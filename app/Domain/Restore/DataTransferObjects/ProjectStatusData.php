<?php

namespace SAAS\Domain\Restore\DataTransferObjects;

use SAAS\Domain\Restore\Enums\ProjectStatuses as ProjectStatusEnum;
use SAAS\Domain\Restore\Models\ProjectStatus;
use Spatie\LaravelData\Data;

class ProjectStatusData extends Data
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

    public static function fromEnum(ProjectStatusEnum $status): self
    {
        return self::fromModel(
            ProjectStatus::whereSlug($status->value)->first()
        );
    }

    public static function fromModel(ProjectStatus $projectStatus)
    {
        return self::from([
            ...$projectStatus->toArray(),
        ]);
    }
}
