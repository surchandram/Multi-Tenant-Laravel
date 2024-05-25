<?php

namespace SAAS\Domain\Plans\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Plans\Models\Plan;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class PlanData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $interval,
        public readonly string $provider_id,
        public readonly ?string $gateway_id,
        public readonly int $price,
        public readonly bool $usable,
        public readonly ?bool $per_seat,
        public readonly ?bool $teams,
        public readonly ?bool $synced_to_provider,
        public readonly ?string $description,
        public readonly ?string $formatted_interval,
        public readonly ?string $formatted_price,
        public readonly ?int $subscribers_count,
        public readonly ?int $team_limit,
        public readonly ?int $team_subscribers_count,
        public readonly ?string $created_at,
        /** @var DataCollection<PlanFeatureData> */
        public readonly null|Lazy|DataCollection $features,
    ) {
    }

    public static function fromRequest(Request $request)
    {
        return self::from([
            ...$request->validated(),
        ]);
    }

    public static function fromModel(Plan $plan)
    {
        return self::from([
            ...$plan->toArray(),
            'price' => $plan->price->amount(),
            'team_limit' => ! $plan->per_seat ? $plan->feature('users')?->limit : null,
            'formatted_price' => $plan->formatted_price,
            'formatted_interval' => Plan::$intervals[$plan->interval] ?? '',
        ]);
    }
}
