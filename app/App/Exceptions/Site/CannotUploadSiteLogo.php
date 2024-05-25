<?php

namespace SAAS\App\Exceptions\Site;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class CannotUploadSiteLogo extends Exception
{
    public static function because(string $message, ?array $trace)
    {
        Log::error($message, Arr::wrap($trace));

        return throw new self($message);
    }
}
