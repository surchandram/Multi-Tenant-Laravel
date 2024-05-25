<?php

namespace SAAS\App\Filters\Dates;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;
use SAAS\App\Filters\FilterExtensionTrait;

class CreatedAtRangeFilter extends FilterAbstract
{
    use FilterExtensionTrait;

    public function operators()
    {
        return [
            'from' => '>=',
            'to' => '<=',
        ];
    }

    /**
     * Apply filter to query records that match "created_at" value.
     *
     * @param  string  $value
     * @param  string  $filterKey
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter(Builder $builder, $value, $filterKey = null)
    {
        if ($value == null) {
            return $builder;
        }

        return $builder->whereDate('created_at', $this->resolveFilterOperator($filterKey), $value);
    }
}
