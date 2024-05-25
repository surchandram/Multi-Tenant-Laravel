<?php

namespace SAAS\Domain\Teams\DataTransferObjects;

use Spatie\LaravelData\Data;

class TeamsCountData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly int $active,
    ) {
    }
}
