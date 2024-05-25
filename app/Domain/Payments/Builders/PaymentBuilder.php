<?php

namespace SAAS\Domain\Payments\Builders;

use Illuminate\Database\Eloquent\Builder;
use SAAS\Domain\Shared\Filters\DateFilter;

class PaymentBuilder extends Builder
{
    public function whereCreatedBetween(DateFilter $dateFilter): self
    {
        return $this->whereBetween(
            'created_at',
            $dateFilter->toArray()
        );
    }
}
