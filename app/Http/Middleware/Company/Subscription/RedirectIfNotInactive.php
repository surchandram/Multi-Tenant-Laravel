<?php

namespace SAAS\Http\Middleware\Company\Subscription;

use Closure;

class RedirectIfNotInactive
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

        if ($company->hasSubscription($subscription)) {
            return redirect()->route('tenant.switch', $company);
        }

        return $next($request);
    }
}
