<?php

namespace SAAS\Domain\Tickets\Models;

use Illuminate\Database\Eloquent\Builder;
use SAAS\Domain\Tickets\Filters\TicketFilters;

class Ticket extends \Saasplayground\SupportTickets\Tickets\Models\Ticket
{
    /**
     * Scope a query to include only "records" that match passed filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param $request
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        return (new TicketFilters($request))->add($filters)->filter($builder);
    }
}
