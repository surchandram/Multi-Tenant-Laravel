<?php

namespace SAAS\App\TwoFactor;

use SAAS\Domain\TwoFactor\Models\TwoFactor;

trait HasTwoFactorAuthentication
{
    /**
     * Determine if the user's two factor is pending verification.
     *
     * @return bool
     */
    public function twoFactorPendingVerification()
    {
        if (!$this->twoFactor) {
            return false;
        }

        return !$this->twoFactor->isVerified();
    }

    /**
     * Determine if the user has two factor enabled.
     *
     * @return bool
     */
    public function twoFactorEnabled()
    {
        return (bool)optional($this->twoFactor)->isVerified();
    }

    /**
     * Get the user's two factor token.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function twoFactor()
    {
        return $this->hasOne(TwoFactor::class);
    }
}
