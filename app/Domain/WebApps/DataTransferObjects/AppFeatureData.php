<?php

namespace SAAS\Domain\WebApps\DataTransferObjects;

use SAAS\Domain\WebApps\Models\AppFeature;
use Spatie\LaravelData\Data;

class AppFeatureData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $key,
        public readonly ?bool $usable = true,
        public readonly ?bool $default = false,
        public readonly bool $is_unlimited = true,
        public readonly int $limit = 0,
    ) {
    }

    public static function fromModel(AppFeature $appFeature)
    {
        $appFeature->name = $appFeature->feature->name;
        $appFeature->key = $appFeature->feature->key;
        $appFeature->usable = $appFeature->feature->usable;

        return self::from($appFeature->toArray());
    }
}
