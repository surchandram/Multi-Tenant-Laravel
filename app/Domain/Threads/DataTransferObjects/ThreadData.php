<?php

namespace SAAS\Domain\Threads\DataTransferObjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use SAAS\Domain\Threads\Models\Thread;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class ThreadData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $uuid,
        public readonly ?string $created_at,
        public readonly null|array|Model $threadable,
        /** @var DataCollection<MessageData> $messages */
        public readonly null|Lazy|DataCollection $messages,
        /** @var DataCollection<UserData> $users */
        public readonly null|Lazy|DataCollection $users,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
        ]);
    }

    public static function fromModel(Thread $thread)
    {
        return self::from([
            ...$thread->toArray(),
            'messages' => Lazy::whenLoaded(
                'messages',
                $thread,
                fn () => MessageData::collection($thread->messages),
            ),
            'users' => Lazy::whenLoaded(
                'users',
                $thread,
                fn () => UserData::collection($thread->users),
            ),
        ]);
    }
}
