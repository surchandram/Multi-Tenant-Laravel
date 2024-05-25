<?php

namespace SAAS\Http\Admin\Controllers\Pages;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Pages\Models\Page;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaDestroyController extends Controller
{
    /**
     * MediaDestroyController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:browse pages', 'permission:update page']);
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Page $page, Media $media)
    {
        $page->deleteMedia($media);

        if ($request->wantsJson()) {
            return response()->noContent();
        }

        return redirect()->back();
    }
}
