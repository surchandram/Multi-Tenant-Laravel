<?php

namespace SAAS\Http\Account\Controllers\Subscriptions;

use SAAS\Http\Subscriptions\Requests\SubscriptionSwapRequest;
use SAAS\Domain\Plans\Models\Plan;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class SubscriptionSwapController extends Controller
{
    /**
     * SubscriptionSwapController constructor.
     */
    public function __construct()
    {
        $this->middleware(['subscription.notcancelled']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $plans = Plan::withActiveFeatures()
            ->except(optional($request->user()->plan)->id)
            ->active()
            ->forUsers()
            ->get();

        return view(
            'account.subscriptions.swap.index',
            compact('plans')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubscriptionSwapRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionSwapRequest $request)
    {
        $user = $request->user();

        $plan = Plan::find($request->plan);

        if (!$user->canDowngrade($plan)) {
            return back()->withError(
                __('Sorry, you cannot downgrade to a plan that is lower than your current usage.')
            );
        }

        $user->currentSubscription()->swap($plan->provider_id);

        return redirect()->route('account.subscriptions.index')
            ->withSuccess(__('Your subscription has been updated successfully.'));
    }
}
