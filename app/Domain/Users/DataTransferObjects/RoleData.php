<?php

namespace SAAS\Domain\Users\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Users\Models\Permission;
use SAAS\Domain\Users\Models\Role;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class RoleData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $slug,
        public readonly ?string $description,
        public readonly ?string $type,
        public readonly ?bool $is_shared,
        public readonly ?string $created_at,
        public readonly ?int $depth,
        public readonly ?int $children_count,
        public readonly ?int $parent_count,
        public readonly ?int $permissions_count,
        public readonly ?int $users_count,
        public readonly ?bool $usable,
        public readonly ?bool $expired,
        public readonly ?string $expires_at,
        public readonly ?string $role_assigned_at,
        public readonly null|Lazy|RoleData $parent,
        /** @var DataCollection<PermissionData> */
        public readonly null|Lazy|DataCollection $permissions,
    ) {
    }

    public static function fromString(string $slug): self
    {
        return self::fromModel(Role::whereSlug($slug)->first());
    }

    public static function fromId(int $id): self
    {
        return self::fromModel(Role::find($id));
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
            'parent' => $request->validated('parent_id') ? RoleData::fromModel(Role::find($request->validated('parent_id'))) : null,
            'permissions' => PermissionData::collection(Permission::whereIn('id', $request->validated('permissions', []))->get()),
        ]);
    }

    public static function fromModel(Role $role): self
    {
        return self::from([
            ...$role->toArray(),
            'is_shared' => ! filled($role->roleable_type) && ! filled($role->roleable_id),
            'role_assigned_at' => $role->pivot?->created_at,
            'expires_at' => $role->pivot?->expires_at,
            'expired' => ! is_null(($expiryDate = $role->pivot?->expires_at)) ? now()->gt($expiryDate) : false,
            'parent' => Lazy::whenLoaded(
                'parent', $role, fn () => RoleData::from($role->parent)
            ),
            'permissions' => Lazy::whenLoaded(
                'permissions', $role, fn () => PermissionData::collection($role->permissions)
            ),
        ]);
    }
}
