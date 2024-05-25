<?php

namespace SAAS\Domain\Tickets\Filters;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;

class AssignedAgentFilter extends FilterAbstract
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
     * Apply filter to query records that match "agent_id" value.
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

        return $builder->where('agent_id', $this->resolveFilterOperator($value), null);
    }
}
