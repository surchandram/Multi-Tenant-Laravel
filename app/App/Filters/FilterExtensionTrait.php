<?php

namespace SAAS\App\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterExtensionTrait
{
    /**
     * Handle's filter logic.
     *
     * @param  mixed  $value
     * @param  mixed  $filterKey
     * @return mixed
     */
    abstract public function filter(Builder $builder, $value, $filterKey = null);
}
