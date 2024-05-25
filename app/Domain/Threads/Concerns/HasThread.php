<?php

namespace SAAS\Domain\Threads\Concerns;

use SAAS\Domain\Threads\DataTransferObjects\MessageData;
use SAAS\Domain\Threads\Models\Message;
use SAAS\Domain\Threads\Models\Thread;

trait HasThread
{
    public static function bootHasThread()
    {
        //
    }

    /**
     * Delete message from thread.
     *
     * @param  int|\SAAS\Domain\Threads\Models\Message  $id
     */
    public function removeMessageFromThread($id): ?bool
    {
        $thread = $this->ensureThreadExists();

        if ($id instanceof Message) {
            return $id->delete();
        }

        return $this->thread->messages()->find($id)?->delete();
    }

    /**
     * Update message.
     */
    public function updateMessage(MessageData $messageData): Message
    {
        $message = (Message::firstWhere('id', $messageData->id))->update([
            'body' => $messageData->body,
        ]);

        return $message->fresh();
    }

    /**
     * Post a new message to a thread.
     */
    public function postMessageToThread(MessageData $messageData): Message
    {
        $thread = $this->ensureThreadExists();

        return Message::create([
            'body' => $messageData->body,
            'thread_id' => $thread->id,
            'user_id' => $messageData->user->id,
        ], Message::find($messageData->parent->id));
    }

    /**
     * Get or create thread if not present.
     */
    public function ensureThreadExists(): Thread
    {
        if (! $this->thread) {
            return $this->thread()->create();
        }

        return $this->thread->fresh();
    }

    /**
     * Get the model's thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function thread()
    {
        return $this->morphOne(Thread::class, 'threadable');
    }
}
