<?php

namespace SAAS\App\TwoFactor;

use SAAS\Domain\Users\Models\User;

interface TwoFactor
{
    /**
     * Registers user to provider.
     *
     * @param User $user
     * @return mixed
     */
    public function register(User $user);

    /**
     * Validates the user's token on register or login.
     *
     * @param User $user
     * @param $token
     * @return mixed
     */
    public function validateToken(User $user, $token);

    /**
     * Deletes the user from the provider.
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user);
}
