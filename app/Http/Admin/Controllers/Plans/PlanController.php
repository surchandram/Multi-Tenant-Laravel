<?php

namespace SAAS\Http\Admin\Controllers\Plans;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\App\Payments\Gateway;
use SAAS\Domain\Plans\Actions\CreatePlanAction;
use SAAS\Domain\Plans\Actions\DestroyPlanAction;
use SAAS\Domain\Plans\Actions\UpdatePlanAction;
use SAAS\Domain\Plans\DataTransferObjects\PlanData;
use SAAS\Domain\Plans\Models\Plan;
use SAAS\Domain\Plans\ViewModels\PlansIndexViewModel;
use SAAS\Domain\Plans\ViewModels\UpsertPlanViewModel;
use SAAS\Http\Plans\Requests\PlanStoreRequest;
use SAAS\Http\Plans\Requests\PlanUpdateRequest;

class PlanController extends Controller
{
    /**
     * PlanController constructor.
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new PlansIndexViewModel($request);

        return Inertia::render('admin/views/plans/Index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new UpsertPlanViewModel();

        return Inertia::render('admin/views/plans/Create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PlanStoreRequest $request, Gateway $gateway)
    {
        try {
            $plan = CreatePlanAction::execute(PlanData::fromRequest($request));
        } catch (\Exception $e) {
            Log::error('Failed creating plan.', [$e]);

            return back()->withErrors([
                'general' => $e->getMessage(),
            ])->withError(__('Failed creating plan.'));
        }

        return redirect()->route('admin.plans.index', $plan)->withSuccess(
            __('\':name\' plan added successfully.', ['name' => $plan->name])
        )->withInfo(__('You can now add features to plan.'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        $model = new UpsertPlanViewModel($plan);

        return Inertia::render('admin/views/plans/Edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PlanUpdateRequest $request, Plan $plan)
    {
        try {
            UpdatePlanAction::execute(
                PlanData::fromRequest($request),
                $plan
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return redirect()->route('admin.plans.edit', $plan)
                ->withError(
                    __('Failed updating plan.')
                );
        }

        return redirect()->route('admin.plans.edit', $plan)->withSuccess(__('Plan updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Plan $plan, Gateway $gateway)
    {
        if ($plan->hasSubscribers()) {
            return back()->withError(
                __('You cannot delete \':name\' plan, since it has subscribers.', ['name' => $plan->name])
            )->withInfo(
                __('You can disable plan, to prevent users from using it.')
            );
        }

        try {
            $deleted = DestroyPlanAction::execute($plan);

            if (! $deleted) {
                return back()->withError(
                    __('Failed deleting :name from plans.', ['name' => $plan->name])
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return back()->withWarning($e->getMessage())->withError(
                __('Whoops! Some error occurred when deleting \':name\' plan. Try again!', [
                    'name' => $plan->name,
                ])
            );
        }

        return back()->withSuccess(
            __('\':name\' plan deleted successfully.', ['name' => $plan->name])
        );
    }
}
