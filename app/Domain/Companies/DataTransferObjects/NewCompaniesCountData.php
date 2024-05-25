<?php

namespace SAAS\Domain\Companies\DataTransferObjects;

use Spatie\LaravelData\Data;

class NewCompaniesCountData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly int $this_month,
        public readonly int $this_week,
        public readonly int $today,
    ) {
    }
}
