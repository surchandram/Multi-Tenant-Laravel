<?php

namespace SAAS\Http\Support\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Tickets\Filters\TicketFilters;

class TicketFiltersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return response()->json([
            'data' => TicketFilters::mappings(),
        ]);
    }
}
