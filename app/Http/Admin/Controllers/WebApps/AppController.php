<?php

namespace SAAS\Http\Admin\Controllers\WebApps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\WebApps\Actions\CreateAppAction;
use SAAS\Domain\WebApps\Actions\UpdateAppAction;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\Models\App;
use SAAS\Domain\WebApps\ViewModels\Admin\AppsIndexViewModel;
use SAAS\Domain\WebApps\ViewModels\Admin\AppsUpsertViewModel;
use SAAS\Domain\WebApps\ViewModels\Admin\ShowAppViewModel;
use SAAS\Http\WebApps\Requests\AppStoreRequest;
use SAAS\Http\WebApps\Requests\AppUpdateRequest;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', App::class);

        $model = new AppsIndexViewModel($request);

        return Inertia::render('admin/views/apps/Index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', App::class);

        $data = new AppsUpsertViewModel();

        return Inertia::render('admin/views/apps/Create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AppStoreRequest $request)
    {
        $this->authorize('create', App::class);

        $app = null;

        try {
            $app = CreateAppAction::execute(
                AppData::from($request->validated())
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            if ($request->wantsJson()) {
                return response()->json([
                    'errors' => [
                        'name' => ['Failed saving app.'],
                    ],
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ], 422);
            }

            return back()->withErrors([
                'name' => ['Failed saving app.'],
            ])->withError($e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'redirect' => route('admin.apps.index'),
                'message' => __(':name added successfully.', ['name' => $app->name]),
            ], 201);
        }

        return redirect()->route('admin.apps.index')
            ->withSuccess(
                __(':name added successfully.', ['name' => $app->name])
            );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(App $app)
    {
        $this->authorize('viewAny', App::class);

        $data = new ShowAppViewModel(app: $app);

        return Inertia::render('admin/views/apps/Show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(App $app)
    {
        $this->authorize('update', $app);

        $data = new AppsUpsertViewModel(app: $app);

        return Inertia::render('admin/views/apps/Edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AppUpdateRequest $request, App $app)
    {
        $this->authorize('update', $app);

        try {
            $app = UpdateAppAction::execute(
                AppData::from($request->validated()),
                $app
            );
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'errors' => [
                        'name' => [$e->getMessage()],
                    ],
                    'trace' => $e->getTrace(),
                ], 422);
            }

            return back()->withInput()->withErrors([
                'name' => [$e->getMessage()],
            ]);
        }

        if ($request->wantsJson()) {
            return response()->noContent();
        }

        return redirect()->route('admin.apps.edit', $app)
            ->withSuccess(__('App updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(App $app)
    {
        $this->authorize('delete', $app);
    }
}
