<?php

namespace SAAS\Domain\Tickets\Filters;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;

class ArchivedFilter extends FilterAbstract
{
    /**
     * Database operator mappings.
     *
     * @return array
     */
    public function operators()
    {
        return [
            'true' => '!=',
            'false' => '=',
        ];
    }

    /**
     * Apply filter to query records that match "archived_at" value.
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

        return $builder->where('archived_at', $this->resolveFilterOperator($value), null);
    }
}
