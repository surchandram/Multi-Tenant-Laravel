<?php

namespace SAAS\Http\Middleware\Company;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAppNotSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $appKey = null)
    {
        $company = $request->tenant();

        $apps = $company->apps->load('app');

        if ($apps->count() === 0) {
            return inertia()->location(route(
                'companies.apps.index',
                ['company' => $company, 'app' => $appKey]
            ));
        }

        if (filled($appKey) && ! $apps->contains(fn ($app) => $app->app->key === $appKey)) {
            return inertia()->location(route(
                'companies.apps.setup.index',
                ['company' => $company, 'app' => $appKey]
            ));
        }

        return $next($request);
    }
}
