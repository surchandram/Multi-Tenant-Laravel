<?php

namespace SAAS\Http\Admin\Controllers\Site;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\App\Support\SiteManager;

class SiteLogoController extends Controller
{
    protected SiteManager $siteManager;

    /**
     * SiteLogoController constructor.
     *
     * @return void
     */
    public function __construct(SiteManager $siteManager)
    {
        $this->middleware(['permission:update page']);

        $this->siteManager = $siteManager;
    }

    /**
     * Show the form for uploading a new logo.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageData = $this->siteManager->getPageData();

        return Inertia::render('admin/views/site/Logo', compact('pageData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Pages\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => ['required', 'image:png,jpg,jpeg'],
        ]);

        try {
            $this->siteManager->uploadSiteLogo($request->file('image'));
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

        return redirect()->route('admin.site.logo.index')
            ->withSuccess(__('Logo uploaded successfully.'));
    }
}
