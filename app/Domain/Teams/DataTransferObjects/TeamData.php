<?php

namespace SAAS\Domain\Teams\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class TeamData extends Data
{
    public function __construct(
        public ?int $id,
        public ?string $uuid,
        public string $name,
        public ?string $slug,
        public ?string $description,
        public bool $usable,
        public ?string $created_at,
        public ?int $users_count,
        #[DataCollectionOf(TeamUserData::class)]
        public readonly null|Lazy|DataCollection $users,
    ) {
    }

    public static function fromRequest(Request $request)
    {
        return self::from([
            ...$request->validated(),
            'id' => $request->team?->id,
        ]);
    }
}
