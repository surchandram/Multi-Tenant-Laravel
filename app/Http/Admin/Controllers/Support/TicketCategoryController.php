<?php

namespace SAAS\Http\Admin\Controllers\Support;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use Saasplayground\SupportTickets\Categories\Models\Category;

class TicketCategoryController extends Controller
{
    /**
     * TicketCategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:browse tickets']);
        $this->middleware(['permission:manage ticket categories'])->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::withCount(['tickets'])->get()->toFlatTree();

        return view('admin.support.tickets.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.support.tickets.categories.create');
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
            'description' => ['nullable', 'string', 'max:140'],
            'usable' => ['nullable', 'boolean'],
        ]);

        Category::create($request->only(['name', 'description', 'usable']));

        return redirect()->route('admin.support.tickets.categories.index')
            ->withSuccess(__('Category created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Saasplayground\SupportTickets\Categories\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Saasplayground\SupportTickets\Categories\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.support.tickets.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Saasplayground\SupportTickets\Categories\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:2', 'max:30'],
            'description' => ['nullable', 'string', 'max:140'],
            'usable' => ['nullable', 'boolean'],
        ]);

        $category->update($request->only(['name', 'description', 'usable']));

        return back()->withSuccess(__('Category updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Saasplayground\SupportTickets\Categories\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return back()->withSuccess(__('Category deleted successfully.'));
    }
}
