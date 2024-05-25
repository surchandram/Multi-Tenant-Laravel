<?php

namespace SAAS\App\TwoFactor\Rules;

use SAAS\Domain\Users\Models\User;
use SAAS\App\TwoFactor\TwoFactor;
use Illuminate\Contracts\Validation\Rule;

class ValidTwoFactorToken implements Rule
{
    /**
     * User instance.
     *
     * @var \SAAS\Domain\Users\Models\User
     */
    protected $user;

    /**
     * TwoFactor instance.
     *
     * @var \SAAS\App\TwoFactor\TwoFactor
     */
    protected $twoFactor;

    /**
     * Create a new rule instance.
     *
     * @param \SAAS\Domain\Users\Models\User $user
     * @param \SAAS\App\TwoFactor\TwoFactor $twoFactor
     * @return void
     */
    public function __construct(User $user, TwoFactor $twoFactor)
    {
        $this->user = $user;
        $this->twoFactor = $twoFactor;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->twoFactor->validateToken($this->user, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Invalid verification code.');
    }
}
