<?php

namespace SAAS\Domain\SocialAccount\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\SocialAccount\DataTransferObjects\SocialAccountData;
use SAAS\Domain\Users\Models\User;

class UpsertSocialAccountAction
{
    public static function execute(SocialAccountData $socialAccountData, User $user)
    {
        try {
            $socialAccount = DB::transaction(function () use ($socialAccountData, $user) {
                return $user->socialAccounts()->updateOrCreate([
                    'provider' => $socialAccountData->provider,
                ], [
                    'provider_user_id' => $socialAccountData->provider_user_id,
                ]);
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $socialAccount;
    }
}
