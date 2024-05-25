<?php

namespace SAAS\Domain\Users\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Users\Models\Permission;
use Spatie\LaravelData\Data;

class PermissionData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $slug,
        public readonly ?string $description,
        public readonly ?string $type,
        public readonly ?string $created_at,
        public readonly ?bool $usable = true,
    ) {
    }

    public static function fromString(string $slug): self
    {
        return self::fromModel(Permission::whereSlug($slug)->first());
    }

    public static function fromId(int $id): self
    {
        return self::fromModel(Permission::find($id));
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
        ]);
    }

    public static function fromModel(Permission $permission): self
    {
        return self::from([
            ...$permission->toArray(),
        ]);
    }
}
