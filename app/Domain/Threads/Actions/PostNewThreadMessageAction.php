<?php

namespace SAAS\Domain\Threads\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Threads\DataTransferObjects\MessageData;
use SAAS\Domain\Threads\Models\Message;

class PostNewThreadMessageAction
{
    public static function execute(MessageData $messageData): Message
    {
        try {
            $message = DB::transaction(function () use ($messageData) {
                return Message::create([
                    'body' => $messageData->body,
                    'thread_id' => $messageData->thread->id,
                    'user_id' => $messageData->user->id,
                ], Message::find($messageData->parent?->id));
            });
        } catch (\Exception $exception) {
            Log::error('Failed posting message to thread.', [$exception]);

            throw $exception;
        }

        return $message;
    }
}
