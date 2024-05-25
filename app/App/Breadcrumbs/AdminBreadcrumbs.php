<?php

namespace SAAS\App\Breadcrumbs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AdminBreadcrumbs
{
    /**
     * Request.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * AdminBreadcrumbs constructor.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get a custom array of the request's segments.
     *
     * @param int $from
     * @return array
     */
    public function segments($from = 0)
    {
        $path = request()->path();

        $crumbs = array_filter(($arr = explode('/', $path)), fn($item) => $item !== 'admin');

        $breadcrumbs = [];

        $routesCollection = Route::getRoutes();

        $routes = (collect($routesCollection)->map(fn($route) => $route->uri)->toArray());

        foreach ($crumbs as $index => $crumb) {
            $current = Route::current();

            $prefix = head(explode($crumb, $path));

            $uri = collect(explode('/', $current->uri))->slice(0, $index+1)->join('/');

            $url = url(("{$prefix}" . $crumb));

            $breadcrumbs[(string)$crumb] = [
                'uri' => $uri,
                'url' => $url,
                'exists' => collect($routes)->firstWhere(fn($value) => $value === $uri) !== null
            ];
        }

        return $breadcrumbs;
    }
}
