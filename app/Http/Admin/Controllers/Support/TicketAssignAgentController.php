<?php

namespace SAAS\Http\Admin\Controllers\Support;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Tickets\Models\Ticket;

class TicketAssignAgentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Ticket $ticket)
    {
        $this->validate($request, [
            'agent_id' => ['required', 'exists:users,id'],
        ]);

        $ticket->assignAgent($request->agent_id);

        return back()->withSuccess(__('Agent successfully assigned to ticket.'));
    }
}
