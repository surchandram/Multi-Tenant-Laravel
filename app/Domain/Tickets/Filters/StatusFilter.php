<?php

namespace SAAS\Domain\Tickets\Filters;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;

class StatusFilter extends FilterAbstract
{
    /**
     * Apply filter to query records that match "status" value.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter(Builder $builder, $value)
    {
        if ($value == null) {
            return $builder;
        }

        return $builder->where('status', $value);
    }
}
