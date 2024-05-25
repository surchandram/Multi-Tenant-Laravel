<?php

namespace SAAS\Http\Companies\Controllers\Subscriptions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Laravel\Cashier\Exceptions\IncompletePayment;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\GetCompanySubscriptionsViewModel;
use SAAS\Domain\Plans\Models\Plan;
use SAAS\Http\Subscriptions\Requests\SubscriptionStoreRequest;

class SubscriptionController extends Controller
{
    /**
     * SubscriptionController constructor.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(['auth']);
        $this->middleware(['in_team:'.$request->company]);
        $this->middleware(['permission:manage company subscriptions,company:'.$request->company]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Company $company)
    {
        $model = new GetCompanySubscriptionsViewModel($company);

        return Inertia::render('companies/views/subscriptions/Index', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionStoreRequest $request, Company $company)
    {
        $plan = Plan::find($request->plan);

        try {
            $subscription = $company->newSubscription('main', $plan->provider_id);

            // apply coupon if exists
            if ($request->has('coupon')) {
                $subscription->withCoupon($request->coupon);
            }

            $subscription->create($request->payment_method);

            $company->flushCache();
        } catch (IncompletePayment $exception) {
            Log::error('Failed processing company subscription.', [$exception]);

            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('companies.subscriptions.index', $company)]
            );
        }

        return redirect()->route('companies.show', $company)->withSuccess(
            __('Thank you. Your subscription is now active.')
        );
    }
}
