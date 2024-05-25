<?php

namespace SAAS\Domain\Account\Actions;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use SAAS\Domain\Users\Models\User;

class UpdateProfileAction
{
    public static function execute(UserData $userData): User
    {
        try {
            $user = DB::transaction(function () use ($userData) {
                $user = User::find($userData->id);

                $data = $userData->only(
                    'first_name',
                    'last_name',
                    'username',
                    'email',
                )->toArray();

                // check if email is changed
                if ($changedEmail = ($user->email !== $userData->email && $user instanceof MustVerifyEmail)) {
                    $data['email_verified_at'] = null;
                }

                $user->update($data);

                // send verification email; if changed
                if ($changedEmail) {
                    $user->sendEmailVerificationNotification();
                }

                // upload 'user' avatar if exists
                if (filled($userData->avatar)) {
                    $user->uploadAvatar($userData->avatar);
                }

                return $user;
            });
        } catch (\Exception $exception) {
            Log::error('Failed updating user profile.', [$exception]);

            throw $exception;
        }

        return $user;
    }
}
