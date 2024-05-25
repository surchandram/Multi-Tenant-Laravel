<?php

namespace SAAS\Domain\Companies\DataTransferObjects;

use Illuminate\Support\Arr;
use SAAS\Domain\Users\Models\User;

class CreateCompanyData
{
    /**
     * CreateCompanyData constructor.
     *
     * @return void
     */
    public function __construct(
        public readonly string $name,
        public readonly string $domain,
        public readonly string $email,
        public readonly bool $personal_team,
        public readonly User $user
    ) {
    }

    public static function make(array $data, $user)
    {
        return new CreateCompanyData(
            name: $data['name'],
            domain: $data['domain'],
            email: $data['email'],
            personal_team: $data['personal_team'] ?? false,
            user: $user, // todo: call UserData object to resolve user
        );
    }

    public function toArray()
    {
        $data = get_object_vars($this);

        return array_merge(Arr::except($data, 'user'), [
            'user_id' => $this->user->id,
        ]);
    }
}
