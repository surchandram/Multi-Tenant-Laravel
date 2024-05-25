<?php

namespace SAAS\Domain\WebApps\DataTransferObjects;

use SAAS\Domain\WebApps\Models\App;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class AppData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $key,
        public readonly string $description,
        public readonly string $url,
        public readonly bool $usable,
        public readonly bool $teams_only,
        public readonly bool $primary,
        public readonly bool $subscription,
        public readonly ?bool $has_logo,
        public readonly ?int $features_count,
        public readonly ?int $plans_count,
        public readonly ?int $teams_count,
        /** @var \Illuminate\Http\UploadedFile|string|\Spatie\MediaLibrary\Support\RemoteFile */
        public readonly mixed $logo = null,
        /** @var DataCollection<AppFeatureData> */
        public readonly null|Lazy|DataCollection $features,
        /** @var DataCollection<AppPlanData> */
        public readonly null|Lazy|DataCollection $plans,
    ) {
    }

    public static function fromModel(App $app)
    {
        return self::from([
            ...$app->toArray(),
            'features' => Lazy::whenLoaded(
                'features',
                $app,
                fn () => AppFeatureData::collection($app->features)
            ),
            'plans' => Lazy::whenLoaded(
                'plans',
                $app,
                fn () => AppPlanData::collection($app->plans)
            ),
        ]);
    }
}
