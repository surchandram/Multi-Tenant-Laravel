<?php

namespace SAAS\Domain\Restore\Invitations;

use Exception;

class CustomerInvitationException extends Exception
{
    public static function isInvalid()
    {
        return new self('Invitation is invalid.');
    }

    public static function emailIsInvalid()
    {
        return new self('User email does not match invitation email.');
    }
}
