<?php

namespace SAAS\Domain\Users\DataTransferObjects;

use Spatie\LaravelData\Data;

class NewUsersCountData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly int $this_month,
        public readonly int $this_week,
        public readonly int $today,
    ) {
    }
}
