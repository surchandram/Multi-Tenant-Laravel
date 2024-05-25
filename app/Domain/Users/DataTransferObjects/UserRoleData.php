<?php

namespace SAAS\Domain\Users\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Users\Models\Role;
use Spatie\LaravelData\Data;

class UserRoleData extends Data
{
    public function __construct(
        public readonly ?string $expires_at,
        public readonly ?Role $role,
    ) {
    }

    public static function fromString(string $slug, $expiresAt = null): self
    {
        return self::from([
            'role' => Role::whereSlug($slug)->first(),
            'expires_at' => $expiresAt,
        ]);
    }

    public static function fromId(int $id, $expiresAt = null): self
    {
        return self::from([
            'role' => Role::find($id),
            'expires_at' => $expiresAt,
        ]);
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
            'role' => Role::find($request->validated('role_id')),
        ]);
    }

    public static function fromModel(Role $role): self
    {
        return self::from([
            'role' => $role,
            'expires_at' => $role->pivot?->expires_at,
        ]);
    }
}
