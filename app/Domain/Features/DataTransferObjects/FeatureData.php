<?php

namespace SAAS\Domain\Features\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Features\Models\Feature;
use Spatie\LaravelData\Data;

class FeatureData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $key,
        public readonly ?string $description,
        public readonly ?bool $usable,
        public readonly ?bool $default,
        public readonly ?bool $is_unlimited,
        public readonly ?int $trial_limit = 1,
        public readonly int $limit = 0,
    ) {
    }

    public static function fromRequest(Request $request)
    {
        return self::from([
            ...$request->validated(),
        ]);
    }

    public static function fromModel(Feature $feature)
    {
        return self::from([
            ...$feature->toArray(),
        ]);
    }
}
