<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Actions\CreateCompanyStripeOnboardingLinkAction;
use SAAS\Domain\Companies\Actions\VerifyCompanyStripeAccountAction;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\ShowCompanyViewModel;

class StripeOnboardingController extends Controller
{
    /**
     * StripeOnboardingController constructor.
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
     * Display the onboarding redirection link.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Company $company)
    {
        $model = new ShowCompanyViewModel($company);

        return inertia('companies/views/onboarding/Stripe', compact('model'));
    }

    /**
     * Redirect user to Stripe.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(Company $company)
    {
        /** \Stripe\AccountLink $response */
        $response = CreateCompanyStripeOnboardingLinkAction::execute(
            $company,
            route('companies.onboarding.stripe.redirect', $company),
            route('companies.onboarding.stripe.verify', $company)
        );

        return redirect($response->url);
    }

    /**
     * Verify company Stripe account setup.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, Company $company)
    {
        VerifyCompanyStripeAccountAction::execute($company);

        return redirect()->route('tenant.switch', $company);
    }
}
