<?php

namespace SAAS\Domain\Users\DataTransferObjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SAAS\Domain\Users\Models\Role;
use SAAS\Domain\Users\Models\UserInvitation;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class UserInvitationData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $identifier,
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $type,
        public readonly ?string $message,
        public readonly ?string $status,
        public readonly ?string $first_name,
        public readonly ?string $last_name,
        public readonly ?string $accepted_at,
        public readonly ?string $rejected_at,
        public readonly ?string $role_expires_at,
        public readonly ?string $created_at,
        public readonly ?string $deleted_at,
        public readonly null|Lazy|RoleData $role,
        public readonly null|Lazy|Model $referable,
        public readonly ?array $data = [],
    ) {
    }

    public static function fromRequest(Request $request, Model $referer = null): self
    {
        return self::from([
            ...$request->validated(),
            'role' => ($roleId = $request->validated('role_id')) ? RoleData::fromModel(Role::find($roleId)) : null,
            'referable' => $referer,
        ]);
    }

    public static function fromModel(UserInvitation $userInvitation)
    {
        return self::from([
            ...$userInvitation->toArray(),
            'first_name' => Str::of($userInvitation->name)->ucsplit()->first(),
            'last_name' => Str::of($userInvitation->name)->ucsplit()->last(),
            'role' => Lazy::whenLoaded(
                'role',
                $userInvitation,
                fn () => RoleData::fromModel($userInvitation->role)
            ),
            'referable' => Lazy::whenLoaded(
                'referable',
                $userInvitation,
                fn () => ($userInvitation->referable)
            ),
        ]);
    }
}
