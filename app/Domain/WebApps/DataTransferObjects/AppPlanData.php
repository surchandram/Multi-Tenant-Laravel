<?php

namespace SAAS\Domain\WebApps\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Plans\DataTransferObjects\PlanData;
use SAAS\Domain\Plans\Models\PlanApp;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class AppPlanData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly int $price,
        public readonly ?string $formatted_price,
        public readonly string $provider_id,
        public readonly bool $usable,
        public readonly ?bool $default,
        public readonly ?bool $per_seat,
        public readonly bool $is_unlimited,
        public readonly ?int $limit,
        public readonly null|Lazy|PlanData $plan,
        /** @var DataCollection<AppFeatureData> */
        public readonly ?DataCollection $features,
    ) {
    }

    public static function fromRequest(Request $request)
    {
        return self::from([
            ...$request->validated(),
            'plan' => fn () => PlanData::fromRequest($request),
        ]);
    }

    public static function fromModel(PlanApp $planApp)
    {
        $planApp->name = $planApp->plan->name;
        $planApp->provider_id = $planApp->plan->provider_id;
        $planApp->per_seat = $planApp->plan->per_seat;
        $planApp->usable = $planApp->plan->usable;
        $planApp->price = $planApp->plan->price->amount();
        $planApp->formatted_price = $planApp->plan->formatted_price;

        return self::from([
            ...$planApp->toArray(),
            'limit' => $planApp->plan->team_limit,
            'plan' => Lazy::whenLoaded(
                'plan',
                $planApp,
                fn () => PlanData::fromModel($planApp->plan)
            ),
        ]);
    }
}
