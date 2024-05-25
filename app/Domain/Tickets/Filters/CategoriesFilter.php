<?php

namespace SAAS\Domain\Tickets\Filters;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;

class CategoriesFilter extends FilterAbstract
{
    /**
     * Apply filter to query records that match categories "id" value.
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

        return $builder->whereHas('categories', function (Builder $query) use ($value) {
            return $query->where('category_id', $value);
        });
    }
}
