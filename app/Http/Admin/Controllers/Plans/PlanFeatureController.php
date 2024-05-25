<?php

namespace SAAS\Http\Admin\Controllers\Plans;

use SAAS\Http\Plans\Requests\PlanFeatureStoreRequest;
use SAAS\Http\Plans\Requests\PlanFeatureUpdateRequest;
use SAAS\Domain\Features\Models\Feature;
use SAAS\Domain\Plans\Models\PlanFeature;
use SAAS\Domain\Plans\Models\Plan;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use Illuminate\Support\Str;

class PlanFeatureController extends Controller
{
    /**
     * PlanFeatureController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:browse plans']);
        $this->middleware(['permission:create plan'])->only('create');
        $this->middleware(['permission:update plan'])->only('edit', 'update');
        $this->middleware(['permission:delete plan'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \SAAS\Domain\Plans\Models\Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function index(Plan $plan)
    {
        $features = $plan->features()->with(['feature'])->get();

        return view('admin.plans.features.index', compact('plan', 'features'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \SAAS\Domain\Plans\Models\Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function create(Plan $plan)
    {
        $plan->load([
            'features',
        ]);

        $features = Feature::active()->get();

        return view('admin.plans.features.create', compact('plan', 'features'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlanFeatureStoreRequest $request
     * @param  \SAAS\Domain\Plans\Models\Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function store(PlanFeatureStoreRequest $request, Plan $plan)
    {
        $feature = Feature::find($request->feature);

        $planFeature = new PlanFeature();
        $planFeature->limit = $request->limit ?? 0;
        $planFeature->default = $request->input('default', false);

        $planFeature->feature()->associate($feature);

        $plan->features()->save($planFeature);

        if ($request->add_new) {
            return back()->withSuccess(
                __('\':name\' added to plan features. Add another one.', ['name' => $feature->name])
            );
        }

        return redirect()->route('admin.plans.features.index', $plan)->withSuccess(
            __('\':name\' added to plan features.', ['name' => $feature->name])
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Plans\Models\Plan $plan
     * @param  \SAAS\Domain\Plans\Models\PlanFeature $planFeature
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan, PlanFeature $planFeature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAAS\Domain\Plans\Models\Plan $plan
     * @param  \SAAS\Domain\Plans\Models\PlanFeature $planFeature
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan, PlanFeature $planFeature)
    {
        $features = Feature::active()->get();

        return view('admin.plans.features.edit', compact('plan', 'features', 'planFeature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlanFeatureUpdateRequest $request
     * @param  \SAAS\Domain\Plans\Models\Plan $plan
     * @param  \SAAS\Domain\Plans\Models\PlanFeature $planFeature
     * @return \Illuminate\Http\Response
     */
    public function update(PlanFeatureUpdateRequest $request, Plan $plan, PlanFeature $planFeature)
    {
        $planFeature->limit = $request->limit ?? 0;
        $planFeature->default = $request->input('default', false);
        $planFeature->save();

        return back()->withSuccess(__('Plan feature updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAAS\Domain\Plans\Models\Plan $plan
     * @param  \SAAS\Domain\Plans\Models\PlanFeature $planFeature
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Plan $plan, PlanFeature $planFeature)
    {
        $feature = $planFeature->feature;

        try {
            $planFeature->delete();
        } catch (\Exception $e) {
            return back()->withError(
                __('Whoops! Some error occurred while deleting \':name\' feature from plan.', [
                    'name' => $planFeature->name
                ])
            );
        }

        return back()->withSuccess(
            __('\':name\' deleted from plan features.', ['name' => $feature->name])
        );
    }
}
