<?php

namespace SAAS\Http\Middleware\Subscription;

use Closure;

class RedirectIfNotInactive
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
        if (auth()->check() && auth()->user()->hasSubscription($subscription)) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
