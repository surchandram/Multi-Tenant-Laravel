<?php

namespace SAAS\Http\Admin\Controllers\Support;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use Saasplayground\SupportTickets\SupportTickets;

class TicketStatusStatController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $model = SupportTickets::getTicketsModel();

        $count = $model::filter($request)->count();

        return response()->json([
            'count' => $count,
        ]);
    }
}
