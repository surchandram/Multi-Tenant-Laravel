<?php

namespace SAAS\Http\Middleware\Company;

use Closure;

class AbortIfNotInCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next, $company)
    {
        abort_if(! $request->user()->companies->contains($company), 404);

        return $next($request);
    }
}
