<?php

namespace SAAS\Http\Companies\Controllers\Subscriptions;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\GetCompanySubscriptionSwapViewModel;
use SAAS\Domain\Plans\Models\Plan;
use SAAS\Http\Subscriptions\Requests\SubscriptionSwapRequest;

class SubscriptionSwapController extends Controller
{
    /**
     * SubscriptionSwapController constructor.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(['auth']);
        $this->middleware(['in_team:'.$request->company]);
        $this->middleware(['team_subscription.notcancelled']);
        $this->middleware(['permission:manage company subscriptions,company:'.$request->company]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Company $company)
    {
        $model = new GetCompanySubscriptionSwapViewModel($company);

        return Inertia::render('companies/views/subscriptions/swap/Index', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionSwapRequest $request, Company $company)
    {
        $plan = Plan::find($request->plan);

        if (! $company->canDowngrade($plan)) {
            return back()->withError(
                __('app.subscription.downgrade_forbidden')
            );
        }

        $company->currentSubscription()->swap($plan->provider_id);

        $company->flushCache();

        return redirect()->route('companies.subscriptions.index', $company)
            ->withSuccess(__('Your company\'s subscription has been updated successfully.'));
    }
}
