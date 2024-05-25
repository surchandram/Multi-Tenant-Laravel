<?php

namespace SAAS\Http\Companies\Controllers\Subscriptions;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\GetCompanySubscriptionCancellationViewModel;
use SAAS\Http\Subscriptions\Requests\SubscriptionConfirmationRequest;

class SubscriptionResumeController extends Controller
{
    /**
     * SubscriptionResumeController constructor.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(['auth']);
        $this->middleware(['in_team:'.$request->company]);
        $this->middleware(['team_subscription.cancelled']);
        $this->middleware(['permission:manage company subscriptions,company:'.$request->company]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Company $company)
    {
        $model = new GetCompanySubscriptionCancellationViewModel($company);

        return Inertia::render('companies/views/subscriptions/Resume', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionConfirmationRequest $request, Company $company)
    {
        $subscription = $company->currentSubscription();

        if (! optional($subscription)->onGracePeriod()) {
            return redirect()->route('companies.subscriptions.index', $company)
                ->withInfo(__('app.subscription.not_active'));
        }

        $subscription->resume();

        $company->flushCache();

        return redirect()->route('companies.subscriptions.index', $company)
            ->withSuccess(__('app.subscription.resumed'));
    }
}
