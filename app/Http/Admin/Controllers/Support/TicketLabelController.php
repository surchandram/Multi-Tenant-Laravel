<?php

namespace SAAS\Http\Admin\Controllers\Support;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use Saasplayground\SupportTickets\Labels\Models\Label;

class TicketLabelController extends Controller
{
    /**
     * TicketLabelController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:browse tickets']);
        $this->middleware(['permission:manage ticket labels'])->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::withCount(['tickets'])->get();

        return view('admin.support.tickets.labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.support.tickets.labels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:2', 'max:30'],
            'usable' => ['nullable', 'boolean'],
        ]);

        Label::create($request->only(['name', 'usable']));

        return redirect()->route('admin.support.tickets.labels.index')
            ->withSuccess(__('Label created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Saasplayground\SupportTickets\Labels\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Saasplayground\SupportTickets\Labels\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        return view('admin.support.tickets.labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Saasplayground\SupportTickets\Labels\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:2', 'max:30'],
            'usable' => ['nullable', 'boolean'],
        ]);

        $label->update($request->only(['name', 'usable']));

        return back()->withSuccess(__('Label updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Saasplayground\SupportTickets\Labels\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        $label->delete();

        return back()->withSuccess(__('Label deleted successfully.'));
    }
}
