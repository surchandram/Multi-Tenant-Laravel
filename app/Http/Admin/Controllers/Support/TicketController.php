<?php

namespace SAAS\Http\Admin\Controllers\Support;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Users\Models\User;
use SAAS\Http\Support\Requests\TicketStoreRequest;
use Saasplayground\SupportTickets\SupportTickets;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Ticket::class);

        $model = SupportTickets::getTicketsModel();

        $tickets = $model::filter($request)->paginate();

        return view('admin.support.tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Tickets\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->loadMissing([
            'categories',
            'labels',
            'messages.user',
            'user',
            'agent',
        ]);

        // todo: scope by agent role or ticket permissions
        $users = User::get();

        $stillOpen = $ticket->status == SupportTickets::STATUS_OPEN;
        // dd($ticket);

        return view('admin.support.tickets.show', compact('ticket', 'users', 'stillOpen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Tickets\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $this->validate($request, [
            'status' => [
                'required',
                Rule::in(SupportTickets::getStatusMap()),
            ],
            'locked' => ['nullable'],
        ]);

        $request->mergeIfMissing([
            'locked_at' => $request->locked ? now() : null,
            'resolved_at' => $request->status === SupportTickets::STATUS_RESOLVED ? now() : null,
        ]);

        $ticket->update($request->only('status', 'resolved_at', 'locked_at'));

        // todo: send notification

        return back()->withSuccess(
            __('Ticket updated successfully.')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAAS\Domain\Tickets\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('destroy', $ticket);

        $ticket->delete();

        return back()->withSuccess(__('Ticket successfully deleted'));
    }
}
