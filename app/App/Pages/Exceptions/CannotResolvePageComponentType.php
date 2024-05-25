<?php

namespace SAAS\App\Pages\Exceptions;

use Exception;

class CannotResolvePageComponentType extends Exception
{
    public static function because($message)
    {
        return new self($message);
    }
}
