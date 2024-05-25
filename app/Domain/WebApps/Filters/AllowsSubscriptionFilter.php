<?php

namespace SAAS\Domain\WebApps\Filters;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;

class AllowsSubscriptionFilter extends FilterAbstract
{
    /**
     * Database value mappings.
     *
     * @return array
     */
    public function mappings()
    {
        return [
            'true' => true,
            'false' => false,
        ];
    }

    /**
     * Apply filter to query records that match "subscription" value.
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

        return $builder->where('subscription', $this->resolveFilterValue($value));
    }
}
