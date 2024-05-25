<?php

namespace SAAS\App\Support\Traits\Eloquent;

use Illuminate\Database\Eloquent\Builder;

trait IsUsable
{
    /**
     * Scope query to include only `active` records.
     *
     * @param Builder $builder
     * @param string $column
     * @return Builder
     */
    public function scopeActive(Builder $builder, $column = 'usable')
    {
        return $builder->where($column, true);
    }

    /**
     * Scope query to include only `disabled` records.
     *
     * @param Builder $builder
     * @param string $column
     * @return Builder
     */
    public function scopeDisabled(Builder $builder, $column = 'usable')
    {
        return $builder->where($column, false);
    }
}
