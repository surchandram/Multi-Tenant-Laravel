<?php

namespace SAAS\Domain\Teams\DataTransferObjects;

use SAAS\Domain\Users\Models\User;
use Spatie\LaravelData\Data;

class TeamUserData extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $email,
        public ?string $created_at = null,
    ) {
    }

    public static function fromModel(User $user)
    {
        return self::from([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->pivot->created_at,
        ]);
    }
}
