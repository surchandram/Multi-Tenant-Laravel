<?php

namespace SAAS\Domain\Threads\DataTransferObjects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SAAS\Domain\Threads\Models\Message;
use SAAS\Domain\Threads\Models\Thread;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use SAAS\Domain\Users\Models\User;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class MessageData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $body,
        public readonly ?int $parent_id,
        public readonly ?bool $is_owner,
        public readonly ?string $edited_at,
        public readonly ?string $created_at,
        public readonly null|Lazy|MessageData $parent,
        public readonly null|Lazy|UserData $user,
        public readonly null|Lazy|ThreadData $thread,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
            'parent' => $request->validated('parent_id') ?
                MessageData::fromModel(Message::find($request->parent_id)) : null,
            'thread' => $request->validated('thread_id') ?
                ThreadData::fromModel(Thread::find($request->thread_id)) : null,
            'user' => $request->validated('user_id') ?
                UserData::fromModel(User::find($request->user_id)) : null,
        ]);
    }

    public static function fromModel(Message $message)
    {
        return self::from([
            ...$message->toArray(),
            'is_owner' => $message->user_id == Auth::user()->getAuthIdentifier(),
            'parent' => Lazy::whenLoaded(
                'parent',
                $message,
                fn () => MessageData::fromModel($message->parent),
            ),
            'thread' => Lazy::whenLoaded(
                'thread',
                $message,
                fn () => ThreadData::fromModel($message->thread),
            ),
            'user' => Lazy::whenLoaded(
                'user',
                $message,
                fn () => UserData::fromModel($message->user),
            ),
        ]);
    }
}
