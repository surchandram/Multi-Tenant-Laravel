<?php

namespace SAAS\Domain\Threads\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Threads\Models\Message;

class DeleteMessageAction
{
    public static function execute(Message $message): ?bool
    {
        try {
            $deleted = DB::transaction(function () use ($message) {
                return $message->delete();
            });
        } catch (\Exception $exception) {
            Log::error('Failed deleting message from thread.', [$exception]);

            throw $exception;
        }

        return $deleted;
    }
}
