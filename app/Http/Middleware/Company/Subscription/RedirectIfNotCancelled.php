<?php

namespace SAAS\Http\Middleware\Company\Subscription;

use Closure;

class RedirectIfNotCancelled
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

        if ($company->hasNotCancelled($subscription)) {
            return redirect()->route('companies.show', $company);
        }

        return $next($request);
    }
}
