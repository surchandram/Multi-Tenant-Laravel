<?php

namespace SAAS\Http\Middleware\Subscription;

use Closure;

class RedirectIfNotCancelled
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
        if (auth()->check() && auth()->user()->hasNotCancelled($subscription)) {
            return redirect()->route('account.index');
        }

        return $next($request);
    }
}
