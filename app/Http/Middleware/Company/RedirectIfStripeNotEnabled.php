<?php

namespace SAAS\Http\Middleware\Company;

use Closure;
use Illuminate\Http\Request;

class RedirectIfStripeNotEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $alertOnly = false)
    {
        if (! ($company = $request->tenant())->stripe_account_enabled) {
            if ($alertOnly) {
                session()->flash('notice', [
                    'title' => __('app.company.stripe.setup_prompt'),
                    'body' => __('app.company.stripe.onboarding'),
                    'action' => [
                        'label' => __('app.labels.complete_setup'),
                        'url' => route('companies.onboarding.stripe.index', $company),
                    ],
                ]);
            } else {
                return redirect()->route('companies.onboarding.stripe.index', $company);
            }
        }

        return $next($request);
    }
}
