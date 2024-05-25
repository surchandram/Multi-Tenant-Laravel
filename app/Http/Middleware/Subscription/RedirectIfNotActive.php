<?php

namespace SAAS\Http\Middleware\Subscription;

use Closure;

class RedirectIfNotActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $subscription
     * @return mixed
     */
    public function handle($request, Closure $next, $subscription = 'main')
    {
        if (auth()->check() && auth()->user()->hasNoSubscription($subscription)) {
            return redirect()->route('account.index');
        }

        return $next($request);
    }
}
