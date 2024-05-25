<?php

namespace SAAS\Http\Account\Controllers\Subscriptions;

use SAAS\Http\Subscriptions\Requests\SubscriptionConfirmationRequest;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class SubscriptionCancelController extends Controller
{
    /**
     * SubscriptionCancelController constructor.
     */
    public function __construct()
    {
        $this->middleware(['subscription.notcancelled']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.subscriptions.cancel.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubscriptionConfirmationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionConfirmationRequest $request)
    {
        $request->user()->currentSubscription()->cancel();

        return redirect()->route('account.index')
            ->withSuccess(__('Your subscription has been cancelled.'))
            ->withInfo(__('You can resume anytime before it ends. Disclaimer: Only applies for non trial users.'));
    }
}
