<?php

namespace SAAS\Http\Middleware\Company\Subscription;

use Closure;

class RedirectIfNotActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $subscription
     * @return mixed
     */
    public function handle($request, Closure $next, $subscription = 'main')
    {
        $company = $request->company;

        if ($company->hasNoSubscription($subscription)) {
            return redirect()->route('companies.subscriptions.index', $company);
        }

        return $next($request);
    }
}
