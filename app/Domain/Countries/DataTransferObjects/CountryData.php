<?php

namespace SAAS\Domain\Countries\DataTransferObjects;

use Spatie\LaravelData\Data;

class CountryData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $dial_code,
        public readonly ?string $code,
        public readonly ?bool $usable = false,
    ) {
    }
}
