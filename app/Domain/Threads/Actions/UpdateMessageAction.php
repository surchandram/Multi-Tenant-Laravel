<?php

namespace SAAS\Domain\Threads\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Threads\DataTransferObjects\MessageData;
use SAAS\Domain\Threads\Models\Message;

class UpdateMessageAction
{
    public static function execute(MessageData $messageData, Message $message)
    {
        try {
            $updated = DB::transaction(function () use ($messageData, $message) {
                return $message->update([
                    'body' => $messageData->body,
                ]);
            });
        } catch (\Exception $exception) {
            Log::error('Failed updating message.', [$exception]);

            throw $exception;
        }

        return $message->fresh();
    }
}
