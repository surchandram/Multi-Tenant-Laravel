<?php

namespace SAAS\Lang;

use Spatie\LaravelData\Data;

class LangData extends Data
{
    public function __construct(
        public readonly string $value,
        public readonly string $label,
    ) {
    }

    public static function fromEnum(Lang $lang): self
    {
        return self::from([
            'value' => $lang->value,
            'label' => $lang->label(),
        ]);
    }
}
