<?php

namespace SAAS\Domain\Settings\DataTransferObjects;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;

class SettingGroupData extends Data
{
    public function __construct(
        public readonly string $label,
        public readonly array $collection,
        public readonly ?string $description,
    ) {
    }

    public static function fromValues(string $label, $collection, string $description = null)
    {
        return self::from([
            'label' => $label,
            'description' => $description,
            'collection' => Arr::wrap($collection),
        ]);
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
        ]);
    }
}
