<?php

namespace SAAS\Http\Admin\Controllers\Pages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Pages\Models\Page;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PageImagesController extends Controller
{
    /**
     * PageImagesController constructor.
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
     * @param  \SAAS\Domain\Pages\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function index(Page $page)
    {
        $page->loadMissing(['media']);

        $pageData = $page;

        return Inertia::render('admin/views/pages/ManageImages', compact('pageData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \SAAS\Domain\Pages\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function create(Page $page)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Pages\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Page $page)
    {
        $this->validate($request, [
            'images.*' => ['required', 'image:png,jpg,jpeg'],
        ]);

        try {
            DB::transaction(function () use (&$page) {
                $page->addMediaFromRequest('images')
                    ->withResponsiveImages()
                    ->toMediaCollection('images');
            });
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => [
                        'images' => [$e->getMessage()],
                    ],
                    'trace' => $e->getTrace(),
                ], 422);
            }

            return back()->withInput()->withErrors([
                'images' => [$e->getMessage()],
            ]);
        }

        return redirect()->route('admin.pages.images.index', $page)
                ->withSuccess(__('Image uploaded successfully.'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Pages\Models\Page  $page
     * @param  \Spatie\MediaLibrary\MediaCollections\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAAS\Domain\Pages\Models\Page  $page
     * @param  \Spatie\MediaLibrary\MediaCollections\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page, Media $media)
    {
        //
    }
}
