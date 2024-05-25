<?php

namespace SAAS\Domain\Users\Filters;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;

class NameFilter extends FilterAbstract
{
    /**
     * Apply filter to query records that match "name" value.
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

        return $builder->where('first_name', 'LIKE', "%{$value}%")
                    ->orWhere('last_name', 'LIKE', "%{$value}%")
                    ->orWhere('email', 'LIKE', "%{$value}%")
                    ->orWhere('username', 'LIKE', "%{$value}%");
    }
}
