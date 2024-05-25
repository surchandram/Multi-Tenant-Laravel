<?php

namespace SAAS\Domain\Companies\DataTransferObjects;

use SAAS\Domain\Users\Models\User;
use Spatie\LaravelData\Data;

class CompanyUserData extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $email,
        public ?string $role,
        public ?string $created_at = null,
    ) {
    }

    public static function fromModel(User $user)
    {
        return self::from([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->roles?->first()?->name,
            'created_at' => $user->pivot->created_at,
        ]);
    }
}
