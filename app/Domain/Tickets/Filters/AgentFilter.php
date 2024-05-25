<?php

namespace SAAS\Domain\Tickets\Filters;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;

class AgentFilter extends FilterAbstract
{
    /**
     * Apply filter to query records that match agent "agent_id" value.
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

        return $builder->whereHas('agent', function (Builder $query) use ($value) {
            return $query->where('agent_id', $value);
        });
    }
}
