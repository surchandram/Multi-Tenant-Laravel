<?php

namespace SAAS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SAAS\Lang\Lang;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        app()->setLocale(
            Lang::tryFrom(
                $request->session()->get('language', config('app.locale'))
            )->value
        );

        return $next($request);
    }
}
