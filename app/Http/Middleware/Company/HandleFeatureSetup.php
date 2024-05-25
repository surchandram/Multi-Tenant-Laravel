<?php

namespace SAAS\Http\Middleware\Company;

use Closure;
use Illuminate\Http\Request;
use SAAS\Domain\Tenant\Events\SetupTenantFeature;

class HandleFeatureSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  $feature
     * @param  bool  $feature
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $feature = null, $onFly = true)
    {
        if (! empty($feature) && $this->resolveKeyPresence($feature)) {
            // fire even to handle feature setup
            event(new SetupTenantFeature($request->tenant(), $feature, ! $onFly));
        }

        return $next($request);
    }

    /**
     * Resolve feature key presence from an array of migration keys.
     *
     * Undocumented function long description
     *
     * @param  string  $key Value of a feature key
     * @return bool
     **/
    public function resolveKeyPresence(string $key)
    {
        return in_array($key, array_keys(config('saas.features.migrations')));
    }
}
