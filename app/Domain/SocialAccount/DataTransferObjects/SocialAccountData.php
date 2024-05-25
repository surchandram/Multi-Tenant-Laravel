<?php

namespace SAAS\Domain\SocialAccount\DataTransferObjects;

use Laravel\Socialite\Contracts\User as SocialUser;
use SAAS\Domain\SocialAccount\Models\SocialAccount;
use Spatie\LaravelData\Data;

class SocialAccountData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $user_id,
        public readonly string $provider,
        public readonly string $provider_user_id,
    ) {
    }

    public static function fromModel(SocialAccount $socialAccount): self
    {
        return self::from([
            ...$socialAccount->toArray()
        ]);
    }

    public static function fromSocialAuth(SocialUser $socialUser, string $provider): self
    {
        return self::from([
            'provider' => $provider,
            'provider_user_id' => $socialUser->getId()
        ]);
    }
}
