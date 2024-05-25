<?php

namespace SAAS\Http\Middleware\Company\Subscription;

use Closure;

class RedirectIfNotCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $company = $request->company;

        if (! $company->isCustomer()) {
            return redirect()->route('companies.show', $company);
        }

        return $next($request);
    }
}
