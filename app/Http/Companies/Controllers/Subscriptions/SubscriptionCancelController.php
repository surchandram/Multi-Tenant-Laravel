<?php

namespace SAAS\Http\Companies\Controllers\Subscriptions;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\GetCompanySubscriptionCancellationViewModel;
use SAAS\Http\Subscriptions\Requests\SubscriptionConfirmationRequest;

class SubscriptionCancelController extends Controller
{
    /**
     * SubscriptionCancelController constructor.
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
        $model = new GetCompanySubscriptionCancellationViewModel($company);

        return Inertia::render('companies/views/subscriptions/Cancel', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionConfirmationRequest $request, Company $company)
    {
        $company->currentSubscription()->cancel();

        $company->flushCache();

        return redirect()->route('companies.show', $company)
            ->withSuccess(__('app.subscription.cancelled'))
            ->withInfo(__('app.subscription.cancelled_disclaimer'));
    }
}
