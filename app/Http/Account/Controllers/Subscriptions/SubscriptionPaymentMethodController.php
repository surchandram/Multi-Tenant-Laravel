<?php

namespace SAAS\Http\Account\Controllers\Subscriptions;

use SAAS\Http\Subscriptions\Requests\SubscriptionPaymentMethodUpdateRequest;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class SubscriptionPaymentMethodController extends Controller
{
    /**
     * SubscriptionPaymentMethodController constructor.
     */
    public function __construct()
    {
        $this->middleware(['subscription.customer']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $intent = null;

        try {
            $intent = $request->user()->createSetupIntent();
        } catch (\Exception $e) {
            logger($e->getMessage(), $e->getTrace());
        }
 
        return view('account.subscriptions.payment_method.index', compact('intent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \SAAS\Http\Subscriptions\Requests\SubscriptionPaymentMethodUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionPaymentMethodUpdateRequest $request)
    {
        $user = $request->user();

        $user->updateDefaultPaymentMethod($request->payment_method);

        $user->updateDefaultPaymentMethodFromStripe();

        return redirect()->route('account.index')->withSuccess(__('Your card has been successfully updated.'));
    }
}
