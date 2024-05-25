<?php

namespace SAAS\App\Support\Traits\Eloquent;

use Illuminate\Database\Eloquent\Builder;

trait PivotOrderableTrait
{
    /**
     * Order query results by pivot column.
     *
     * @param Builder $builder
     * @param string $column
     * @param string $order
     * @return mixed
     */
    public function scopeOrderByPivot(Builder $builder, $column = 'created_at', $order = 'desc')
    {
        return $builder->orderBy('pivot_' . $column, $order);
    }
}
