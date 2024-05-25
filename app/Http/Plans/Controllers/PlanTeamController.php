<?php

namespace SAAS\Http\Plans\Controllers;

use SAAS\Domain\Plans\Models\Plan;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class PlanTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $plans = Plan::withActiveFeatures()->active()->forTeams()->get();

        return view('plans.teams.index', compact('plans'));
    }
}
