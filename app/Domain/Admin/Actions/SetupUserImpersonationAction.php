<?php

namespace SAAS\Domain\Admin\Actions;

use SAAS\Domain\Users\Models\User;

class SetupUserImpersonationAction
{
    public static function execute(string $email): User
    {
        $user = User::where('email', $email)->first();

        session()->put('impersonate', $user->id);

        return $user;
    }
}
