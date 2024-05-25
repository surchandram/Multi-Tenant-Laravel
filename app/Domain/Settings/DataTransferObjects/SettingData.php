<?php

namespace SAAS\Domain\Settings\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class SettingData extends Data
{
    public function __construct(
        public readonly string $label,
        public readonly mixed $value,
        public readonly ?string $description,
    ) {
    }

    public static function fromValues(string $label, mixed $value, string $description = null)
    {
        return self::from([
            'label' => $label,
            'value' => $value,
            'description' => $description,
        ]);
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->validated(),
        ]);
    }
}
