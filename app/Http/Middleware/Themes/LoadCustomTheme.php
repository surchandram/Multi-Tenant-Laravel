<?php

namespace SAAS\Http\Middleware\Themes;

use Closure;
use Illuminate\Http\Request;
use Laraeast\LaravelSettings\Facades\Settings;

class LoadCustomTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $app = app();

        $viewFinder = $app['view']->getFinder();

        $theme = 'themes/'.Settings::get('app.theme', 'tailadmin');

        $basePath = ($app['path.resources'].'/'.$theme);

        $paths = $viewFinder->getPaths();

        $themePath = $basePath;

        $newPaths = array_merge([$themePath], $paths);

        $viewFinder->setPaths($newPaths);

        $app->instance('view.finder', $viewFinder);

        return $next($request);
    }
}
