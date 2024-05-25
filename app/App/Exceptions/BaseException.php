<?php

namespace SAAS\App\Exceptions;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class BaseException extends Exception
{
    public static function because(string $message, ?array $trace)
    {
        Log::error($message, Arr::wrap($trace));

        return throw new self($message);
    }
}
