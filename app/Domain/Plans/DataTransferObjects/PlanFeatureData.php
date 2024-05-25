<?php

namespace SAAS\Domain\Plans\DataTransferObjects;

use Illuminate\Http\Request;
use SAAS\Domain\Features\DataTransferObjects\FeatureData;
use SAAS\Domain\Plans\Models\PlanFeature;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class PlanFeatureData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly null|Lazy|PlanData $plan,
        public readonly null|Lazy|FeatureData $feature,
        public readonly ?bool $default = false,
        public readonly bool $is_unlimited = true,
        public readonly int $limit = 0,
    ) {
    }

    public static function fromRequest(Request $request)
    {
        return self::from([
            ...$request->validated(),
            'plan' => PlanData::fromModel($request->plan_id),
            'feature' => FeatureData::fromModel($request->feature_id),
        ]);
    }

    public static function fromModel(PlanFeature $planFeature)
    {
        return self::from([
            ...$planFeature->toArray(),
            'plan' => Lazy::whenLoaded(
                'plan',
                $planFeature,
                fn () => PlanData::fromModel($planFeature->plan),
            ),
            'feature' => Lazy::whenLoaded(
                'feature',
                $planFeature,
                fn () => FeatureData::fromModel($planFeature->feature),
            ),
        ]);
    }
}
