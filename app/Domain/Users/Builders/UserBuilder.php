<?php

namespace SAAS\Domain\Users\Builders;

use Illuminate\Database\Eloquent\Builder;
use SAAS\Domain\Shared\Filters\DateFilter;

class UserBuilder extends Builder
{
    public function whereJoinedBetween(DateFilter $dateFilter): self
    {
        return $this->whereBetween(
            'created_at',
            $dateFilter->toArray()
        );
    }
}
