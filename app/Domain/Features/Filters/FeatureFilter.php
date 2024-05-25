<?php

namespace SAAS\Domain\Features\Filters;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;

class FeatureFilter extends FilterAbstract
{
    /**
     * Apply filter to query records that match features "key" value.
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

        return $builder->whereHas('features.feature', function (Builder $query) use ($value) {
            return $query->where('key', $value);
        });
    }
}
