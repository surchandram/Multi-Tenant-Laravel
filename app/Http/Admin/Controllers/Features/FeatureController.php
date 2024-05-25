<?php

namespace SAAS\Http\Admin\Controllers\Features;

use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Features\Actions\CreateFeatureAction;
use SAAS\Domain\Features\Actions\DestroyFeatureAction;
use SAAS\Domain\Features\Actions\UpdateFeatureAction;
use SAAS\Domain\Features\DataTransferObjects\FeatureData;
use SAAS\Domain\Features\Models\Feature;
use SAAS\Domain\Features\ViewModels\Admin\GetFeaturesViewModel;
use SAAS\Domain\Features\ViewModels\Admin\UpsertFeatureViewModel;
use SAAS\Http\Features\Requests\FeatureStoreRequest;
use SAAS\Http\Features\Requests\FeatureUpdateRequest;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index()
    {
        $model = new GetFeaturesViewModel();

        return Inertia::render('admin/views/features/Index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function create()
    {
        return Inertia::render('admin/views/features/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(FeatureStoreRequest $request)
    {
        $name = $request->name;

        $feature = CreateFeatureAction::execute(
            FeatureData::fromRequest($request)
        );

        if (! $feature->exists) {
            return back()->withErrors([
                'name' => __('app.feature.create_failed'),
            ]);
        }

        if ($request->add_new) {
            return back()->withSuccess(
                __('app.feature.create_new_on_success', ['name' => $name])
            );
        }

        return redirect()->route('admin.features.index')->withSuccess(
            __('app.feature.created', ['name' => $name])
        );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function edit(Feature $feature)
    {
        $model = new UpsertFeatureViewModel($feature);

        return Inertia::render('admin/views/features/Edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(FeatureUpdateRequest $request, Feature $feature)
    {
        $feature = UpdateFeatureAction::execute(
            FeatureData::fromRequest($request),
            $feature
        );

        return back()->withSuccess(__('app.feature.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        try {
            DestroyFeatureAction::execute($feature);
        } catch (\Exception $e) {
            return back()->withError(
                __('app.feature.deletion_failed', [
                    'name' => $feature->name,
                ])
            );
        }

        return redirect()->route('admin.features.index')->withSuccess(
            __('app.feature.deleted', ['name' => $feature->name])
        );
    }
}
