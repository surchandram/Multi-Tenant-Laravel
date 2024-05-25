<?php

namespace SAAS\App\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FiltersExtensionTrait
{
    /**
     * Loops through filters and builds them up.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter(Builder $builder)
    {
        foreach ($this->getFilters() as $filter => $value) {
            $this->resolveFilter($filter)->filter($builder, $value, $filter);
        }

        return $builder;
    }
}
