<?php

namespace SAAS\Domain\Payments\DataTransferObjects;

use SAAS\App\Support\DataTransformers\MoneyTransformer;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

class PaymentsSummaryData extends Data
{
    public function __construct(
        #[WithTransformer(MoneyTransformer::class)]
        public readonly int $lifetime,
        #[WithTransformer(MoneyTransformer::class)]
        public readonly int $this_month,
        #[WithTransformer(MoneyTransformer::class)]
        public readonly int $this_week,
        #[WithTransformer(MoneyTransformer::class)]
        public readonly int $today,
    ) {
    }
}
