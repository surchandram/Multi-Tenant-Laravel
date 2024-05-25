<?php

namespace SAAS\Domain\Auth\DataTransferObjects;

use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\User as SocialUser;
use Spatie\LaravelData\Data;

class RegisteredUserData extends Data
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $username,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly ?string $password,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
        ]);
    }

    public static function fromSocialAuth(SocialUser $socialUser): self
    {
        $fullName = explode(" ", $socialUser->getName());
        $nickname = $socialUser->getNickname() ?? strtok($socialUser->getEmail(), "@");

        return self::from([
            'first_name' => $fullName[0],
            'last_name' => $fullName[1],
            'username' => $nickname,
            'email' => $socialUser->getEmail(),
            'phone' => null,
            'password' => null
        ]);
    }
}
