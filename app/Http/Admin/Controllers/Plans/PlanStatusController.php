<?php

namespace SAAS\Http\Admin\Controllers\Plans;

use SAAS\Domain\Plans\Models\Plan;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class PlanStatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Plans\Models\Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Plan $plan)
    {
        $plan->usable = (bool)!$plan->usable;
        $plan->save();

        return back()->withSuccess(
            __('\':name\' plan status updated successfully.', ['name' => $plan->name])
        );
    }
}
