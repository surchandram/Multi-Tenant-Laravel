<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

if (! function_exists('appRouteNames')) {
    /**
     * Get app route names.
     *
     * @return array
     */
    function appRouteNames()
    {
        $routesCollection = Route::getRoutes();

        return collect($routesCollection)->map(fn ($route) => $route->getName())->toArray();
    }
}

if (! function_exists('appUris')) {
    /**
     * Get app uris.
     *
     * @return array
     */
    function appUris()
    {
        $routesCollection = Route::getRoutes();

        return collect($routesCollection)->map(fn ($route) => $route->uri)->toArray();
    }
}

if (! function_exists('feature')) {
    /**
     * Check if a feature is allowed.
     *
     * @param  string  $key
     * @param  bool  $default
     * @return bool
     */
    function feature($key, $default = false)
    {
        return Arr::get(config('saas.features.allowed'), $key, $default);
    }
}

if (! function_exists('mysql_remote_host')) {
    /**
     * Check if a mysql connection uses remote host.
     *
     * @param  bool  $default
     * @return array
     */
    function mysql_remote_host($default = false)
    {
        return env('DB_IS_REMOTE', $default) === true ? [
            PDO::MYSQL_ATTR_SSL_CA => '/var/lib/mysql/cert.pem',
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        ] : [];
    }
}

if (! function_exists('on_page')) {
    /**
     * Check's whether request url/route matches passed link
     *
     * @param $path
     * @param  string  $type
     * @return bool
     */
    function on_page($path, $type = 'name')
    {
        switch ($type) {
            case 'url':
                $result = ($path == request()->is($path));
                break;

            default:
                $result = ($path == request()->route()->getName());
        }

        return $result;
    }
}

if (! function_exists('return_if')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function return_if($condition, $value)
    {
        if ($condition) {
            return $value;
        }
    }
}

if (! function_exists('page_title')) {
    /**
     * Returns page title from passed values
     *
     * @param $title
     * @param $separator
     * @return string
     */
    function page_title($title, $separator = '-', $swap = false)
    {
        if ($swap === true) {
            return "{$separator} {$title}";
        }

        return "{$title} {$separator} ";
    }
}
