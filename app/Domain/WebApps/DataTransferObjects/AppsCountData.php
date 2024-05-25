<?php

namespace SAAS\Domain\WebApps\DataTransferObjects;

use Spatie\LaravelData\Data;

class AppsCountData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly int $active,
    ) {
    }
}
