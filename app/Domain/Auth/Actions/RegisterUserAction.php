<?php

namespace SAAS\Domain\Auth\Actions;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SAAS\Domain\Auth\DataTransferObjects\RegisteredUserData;
use SAAS\Domain\Users\Models\User;

class RegisterUserAction
{
    public static function execute(RegisteredUserData $registeredUserData): User
    {
        try {
            $user = DB::transaction(function () use ($registeredUserData) {
                return User::create([
                    'first_name' => $registeredUserData->first_name,
                    'last_name' => $registeredUserData->last_name,
                    'username' => $registeredUserData->username,
                    'email' => $registeredUserData->email,
                    'phone' => $registeredUserData->phone,
                    'password' => Hash::make($registeredUserData->password),
                ]);
            });

            event(new Registered($user));
        } catch (\Exception $exception) {
            throw $exception;
        }

        return $user;
    }
}
