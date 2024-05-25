<?php

namespace SAAS\Domain\Tickets\Filters;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;

class ResolvedOrder extends FilterAbstract
{
    /**
     * Apply filter to order by "resolved_at" column.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter(Builder $builder, $value)
    {
        return $builder->orderBy('resolved_at', $this->resolveOrderDirection($value));
    }
}
