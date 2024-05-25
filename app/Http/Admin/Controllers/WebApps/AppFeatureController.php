<?php

namespace SAAS\Http\Admin\Controllers\WebApps;

use Illuminate\Support\Facades\DB;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Features\Models\Feature;
use SAAS\Domain\WebApps\Models\App;
use SAAS\Domain\WebApps\Models\AppFeature;
use SAAS\Http\WebApps\Requests\AppFeatureStoreRequest;
use SAAS\Http\WebApps\Requests\AppFeatureUpdateRequest;

class AppFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \SAAS\Domain\Apps\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function index(App $app)
    {
        $this->authorize('viewAny', AppFeature::class);

        $app->loadMissing([
            'features.feature',
        ]);

        return view('admin.apps.features.index', compact('app'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \SAAS\Domain\Apps\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function create(App $app)
    {
        $this->authorize('create', AppFeature::class);

        return view('admin.apps.features.create', compact('app'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \SAAS\Http\WebApps\Requests\AppFeatureStoreRequest  $request
     * @param  \SAAS\Domain\Apps\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function store(AppFeatureStoreRequest $request, App $app)
    {
        $this->authorize('create', AppFeature::class);

        $name = $request->name;

        try {
            DB::transaction(function () use ($request, &$app) {
                $feature = new Feature();
                $feature->fill($request->only(['name', 'key', 'description']));
                $feature->usable = $request->validated('usable', false);
                $feature->is_unlimited = $request->validated('is_unlimited', false);
                $feature->featurable()->associate($app);

                $feature->save();

                $data = array_merge($feature->only(['is_unlimited']), [
                    'feature_id' => $feature->id,
                ]);

                $appFeature = new AppFeature();
                $appFeature->fill($data);
                $appFeature->limit = $request->validated('limit', 0);
                $appFeature->default = $request->input('default', false);

                $appFeature->feature()->associate($feature);

                $app->features()->save($appFeature);
            });
        } catch (\Exception $e) {
            return back()->withInput()->withError(__('Failed adding feature.'));
        }

        if ($request->add_new) {
            return back()->withSuccess(
                __('\':name\' added successfully to app\'s features. Add another one.', ['name' => $name])
            );
        }

        return redirect()->route('admin.apps.features.index', $app)->withSuccess(
            __('\':name\' added successfully to app\'s features.', ['name' => $name])
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Apps\Models\App  $app
     * @param  \SAAS\Domain\WebApps\Models\AppFeature  $appFeature
     * @return \Illuminate\Http\Response
     */
    public function show(App $app, AppFeature $appFeature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAAS\Domain\Apps\Models\App  $app
     * @param  \SAAS\Domain\WebApps\Models\AppFeature  $appFeature
     * @return \Illuminate\Http\Response
     */
    public function edit(App $app, AppFeature $appFeature)
    {
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \SAAS\Http\WebApps\Requests\AppFeatureUpdateRequest  $request
     * @param  \SAAS\Domain\Apps\Models\App  $app
     * @param  \SAAS\Domain\WebApps\Models\AppFeature  $appFeature
     * @return \Illuminate\Http\Response
     */
    public function update(AppFeatureUpdateRequest $request, App $app, AppFeature $appFeature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAAS\Domain\Apps\Models\App  $app
     * @param  \SAAS\Domain\WebApps\Models\AppFeature  $appFeature
     * @return \Illuminate\Http\Response
     */
    public function destroy(App $app, AppFeature $appFeature)
    {
        $this->authorize('delete', $appFeature);

        $name = $appFeature->feature->name;

        $appFeature->feature->forceDelete();

        return back()->withSuccess(
            __(':name feature removed from app.', ['name' => $name])
        );
    }
}
