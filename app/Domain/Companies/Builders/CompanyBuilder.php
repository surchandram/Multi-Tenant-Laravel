<?php

namespace SAAS\Domain\Companies\Builders;

use Illuminate\Database\Eloquent\Builder;
use SAAS\Domain\Shared\Filters\DateFilter;

class CompanyBuilder extends Builder
{
    public function whereCreatedBetween(DateFilter $dateFilter): self
    {
        return $this->whereBetween(
            'created_at',
            $dateFilter->toArray()
        );
    }
}
