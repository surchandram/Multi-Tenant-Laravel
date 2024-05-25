<?php

namespace SAAS\Http\Admin\Controllers\Pages;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Pages\Models\Page;

class PageController extends Controller
{
    /**
     * PageController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:browse pages']);
        $this->middleware(['permission:create page'])->only('create', 'store');
        $this->middleware(['permission:update page'])->only('edit', 'update');
        $this->middleware(['permission:delete page'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::with([
            'media',
        ])->defaultOrder()->paginate();

        return Inertia::render('admin/views/pages/Index', compact('pages'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Pages\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAAS\Domain\Pages\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $pageData = $page;

        return Inertia::render('admin/views/pages/Edit', compact('pageData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Pages\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:250'],
            'name' => [
                'required',
                'string',
                Rule::in(appRouteNames()),
            ],
            'body' => ['nullable', 'string'],
            'usable' => ['required', 'boolean'],
            'hidden' => ['required', 'boolean'],
        ]);

        $page->fill($request->only('title', 'name', 'body', 'usable', 'hidden'));

        $page->save();

        return redirect()->route('admin.pages.images.index', $page)->withSuccess(__('Page updated. You can also change images.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAAS\Domain\Pages\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }
}
