<?php

namespace SAAS\App\Support;

use Illuminate\Database\Query\Expression;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Saas
{
    public static function preferTenantFromStore()
    {
        config()->set('tenancy.routes.subdomain', false);
    }

    public static function tenantMiddlewares()
    {
        return array_merge(
            config('tenancy.routes.middleware.before', []), [
                'tenant',
            ],
            config('tenancy.routes.middleware.after', [])
        );
    }

    /**
     * Get tenant's model store key based on default driver.
     *
     * @return string
     */
    public static function getTenantDriverStoreKey()
    {
        return (tenancy()->config()->storeDriver() === 'db') ? config('tenancy.model.db_key') : config('tenancy.model.key');
    }

    /**
     * Get the defined users table name.
     *
     * @return string
     */
    public static function getUsersTableName()
    {
        return 'users';
    }

    /**
     * Get the defined users table database connection.
     *
     * @return string
     */
    public static function getUsersDbConnection()
    {
        return env('DB_CONNECTION');
    }

    /**
     * Get the default database connection.
     *
     * @return string
     */
    public static function getDefaultDbConnection()
    {
        return env('DB_CONNECTION');
    }

    /**
     * Get the expression used to define users table connection.
     *
     * @return string
     */
    public static function getUsersConnectionExpression()
    {
        $database = DB::connection(Saas::getUsersDbConnection())
            ->getDatabaseName();

        $usersTable = Saas::getUsersTableName();

        return new Expression($database.'.'.$usersTable);
    }

    /**
     * Get the expression used to define countries table connection.
     *
     * @return string
     */
    public static function getCountriesConnectionExpression()
    {
        $database = DB::connection(Saas::getDefaultDbConnection())
            ->getDatabaseName();

        $countriesTable = 'countries';

        return new Expression($database.'.'.$countriesTable);
    }

    /**
     * Get the expression used to define teams table connection.
     *
     * @return string
     */
    public static function getTeamsConnectionExpression()
    {
        $database = DB::connection(Saas::getDefaultDbConnection())
            ->getDatabaseName();

        $countriesTable = 'teams';

        return new Expression($database.'.'.$countriesTable);
    }

    /**
     * Find the path to a localized Markdown resource.
     *
     * @param  string  $name
     * @return string|null
     */
    public static function localizedMarkdownPath($name)
    {
        $localName = preg_replace('#(\.md)$#i', '.'.app()->getLocale().'$1', $name);

        return Arr::first([
            resource_path('markdown/'.$localName),
            resource_path('markdown/'.$name),
        ], function ($path) {
            return file_exists($path);
        });
    }
}
