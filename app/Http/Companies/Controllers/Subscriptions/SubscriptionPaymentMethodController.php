<?php

namespace SAAS\Http\Companies\Controllers\Subscriptions;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\UpdateCompanyPaymentmethodViewModel;

class SubscriptionPaymentMethodController extends Controller
{
    /**
     * SubscriptionPaymentMethodController constructor.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(['auth']);
        $this->middleware(['in_team:'.$request->company]);
        $this->middleware(['team_subscription.customer']);
        $this->middleware(['permission:manage company subscriptions,company:'.$request->company]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Company $company)
    {
        $model = new UpdateCompanyPaymentmethodViewModel($company);

        return Inertia::render('companies/views/subscriptions/PaymentMethod', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->validate($request, [
            'payment_method' => 'required',
        ], [
            'payment_method' => 'card',
        ]);

        $company->updateDefaultPaymentMethod($request->payment_method);

        $company->updateDefaultPaymentMethodFromStripe();

        return redirect()->route('companies.subscriptions.index', $company)
            ->withSuccess(__('app.subscription.card_updated'));
    }
}
