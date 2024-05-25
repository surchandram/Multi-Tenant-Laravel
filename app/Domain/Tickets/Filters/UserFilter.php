<?php

namespace SAAS\Domain\Tickets\Filters;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;

class UserFilter extends FilterAbstract
{
    /**
     * Apply filter to query records that match user "user_id" value.
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

        return $builder->whereHas('user', function (Builder $query) use ($value) {
            return $query->where('user_id', $value);
        });
    }
}
