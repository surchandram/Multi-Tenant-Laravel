<?php

namespace SAAS\Http\Account\Controllers\Subscriptions;

use SAAS\Http\Subscriptions\Requests\SubscriptionStoreRequest;
use SAAS\Domain\Plans\Models\Plan;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $plans = Plan::withActiveFeatures()->active()->forUsers()->get();

        $choosenPlan = $plans->where('id', $request->plan)->first();

        $user = $request->user();

        $hasSubscription = $user->hasSubscription();

        $intent = $hasSubscription ? null : $user->createSetupIntent();

        $invoices = $hasSubscription ? $user->invoices() : collect([]);

        return view(
            'account.subscriptions.index',
            compact('plans', 'choosenPlan', 'intent', 'invoices')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubscriptionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionStoreRequest $request)
    {
        $plan = Plan::find($request->plan);

        $user = $request->user();

        try {
            $subscription = $user->newSubscription('main', $plan->provider_id);

            // apply coupon if exists
            if ($request->has('coupon')) {
                $subscription->withCoupon($request->coupon);
            }

            $subscription->create($request->payment_method, [
                'email' => $user->email,
            ]);
        } catch (IncompletePayment $exception) {
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('account.subscriptions.index')]
            );
        }

        return back()->withSuccess('Thank you. Your subscription is now active.');
    }
}
