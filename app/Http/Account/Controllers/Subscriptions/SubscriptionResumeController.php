<?php

namespace SAAS\Http\Account\Controllers\Subscriptions;

use SAAS\Http\Subscriptions\Requests\SubscriptionConfirmationRequest;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class SubscriptionResumeController extends Controller
{
    /**
     * SubscriptionResumeController constructor.
     */
    public function __construct()
    {
        $this->middleware(['subscription.cancelled']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.subscriptions.resume.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubscriptionConfirmationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionConfirmationRequest $request)
    {
        $subscription = $request->user()->currentSubscription();

        if (!optional($subscription)->onGracePeriod()) {
            return redirect()->route('account.subscriptions.index')
                ->withInfo(__('Your have no active subscription. Please subscribe.'));
        }

        $subscription->resume();

        return redirect()->route('account.subscriptions.index')
            ->withSuccess(__('Your subscription has been resumed.'));
    }
}
