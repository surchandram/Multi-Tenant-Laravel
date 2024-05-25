<?php

namespace SAAS\Http\Admin\Controllers\Pages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Pages\Models\Page;

class PageImageController extends Controller
{
    /**
     * PackageImageController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:update page']);
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
            'image' => ['required', 'image:png,jpg,jpeg'],
        ]);

        try {
            DB::transaction(function () use (&$page) {
                $page->addMediaFromRequest('image')
                    ->withResponsiveImages()
                    ->toMediaCollection('main_image');
            });
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => [
                        'image' => [$e->getMessage()],
                    ],
                    'trace' => $e->getTrace(),
                ], 422);
            }

            return back()->withInput()->withErrors([
                'image' => [$e->getMessage()],
            ]);
        }

        return redirect()->route('admin.pages.images.index', $page)
            ->withSuccess(__('Image uploaded successfully.'));
    }
}
