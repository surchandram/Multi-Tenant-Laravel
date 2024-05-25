<?php

namespace SAAS\Http\Support\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Http\Support\Requests\TicketStoreRequest;
use Saasplayground\SupportTickets\Categories\Models\Category;
use Saasplayground\SupportTickets\Labels\Models\Label;
use Saasplayground\SupportTickets\SupportTickets;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class TicketController extends Controller
{
    /**
     * TicketController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tickets = $request->user()->tickets()->filter($request)->paginate();

        return view('support.tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $priorities = SupportTickets::getPriorityMap();
        $categories = Category::active()->get();
        $labels = Label::active()->get();

        return view('support.tickets.create', compact('priorities', 'categories', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketStoreRequest $request)
    {
        $request->user()->openTicket(
            $request->except('labels', 'categories'),
            $request->only('labels', 'categories')
        );

        return back()->withSuccess(
            __('A new ticket has been opened. An agent will contact you soon.')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $ticket->loadMissing([
            'categories',
            'labels',
            'messages.user',
            'user',
        ]);

        return view('support.tickets.show', compact('ticket'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
