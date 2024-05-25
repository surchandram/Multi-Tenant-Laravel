<?php

namespace SAAS\Http\Support\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class TicketMessageStoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Ticket  $ticket
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Ticket $ticket, Request $request)
    {
        $this->validate($request, [
            'body' => ['required', 'max:5000'],
        ]);

        $ticket->addMessage($request->body);

        return response()->noContent(201);
    }
}
