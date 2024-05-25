<?php

namespace SAAS\App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use SAAS\Domain\WebApps\DataTransferObjects\AppData;
use SAAS\Domain\WebApps\ViewModels\GetRoutableAppsViewModel;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->teamsRoutes();
        $this->customerRoutes();
        $this->appsRoutes();
        $this->apiRoutes();
        $this->adminRoutes();
        $this->webRoutes();
        $this->globalRoutes();
    }

    protected function appUrl()
    {
        return env('APP_URL');
    }

    public function apiRoutes()
    {
        Route::domain($this->appUrl())
            ->middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }

    public function appsRoutes()
    {
        try {
            $model = new GetRoutableAppsViewModel();

            $apps = collect($model)->get('apps');

            collect($apps)
                ->reject(
                    fn ($app) => ! file_exists(
                        base_path("routes/apps/{$app['key']}.php")
                    )
                )
                ->each(function (array $data) {
                    $app = AppData::from($data);

                    $key = $app->key;

                    $domain = $app->url.'.'.parse_url($this->appUrl(), PHP_URL_HOST);

                    Route::domain($domain)
                        ->middleware([
                            'web',
                        ])
                        ->name($key.'.')
                        ->group(base_path("routes/apps/{$key}.php"));
                });
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }
    }

    public function teamsRoutes()
    {
        Route::domain($this->appUrl())->middleware([
            'web',
            'auth',
            \SAAS\Http\Middleware\Themes\LoadCustomTheme::class,
        ])->group(base_path('routes/teams.php'));
    }

    public function adminRoutes()
    {
        Route::domain($this->appUrl())
            ->middleware([
                'web',
                'auth',
                'permission:browse admin',
                \SAAS\Http\Middleware\Themes\LoadCustomTheme::class,
            ])
            ->prefix('admin')
            ->name('admin.')
            ->group(base_path('routes/admin.php'));
    }

    public function customerRoutes()
    {
        $subdomainKey = config('tenancy.routes.subdomain_request_key', 'tenant_domain');

        $domain = '{tenant_domain}.'.parse_url($this->appUrl(), PHP_URL_HOST);

        Route::domain($domain)->middleware(array_merge(
            array_filter(config('tenancy.routes.middleware.before', []), fn ($middleware) => $middleware != 'auth'),
            [
                'auth.customer',
                \SAAS\Http\Middleware\Themes\LoadCustomTheme::class,
            ],
            [
                'tenant.guest',
                'customer',
            ],
            config('tenancy.routes.middleware.after', []),
        ))->prefix('/customers/portal')->as('tenant.customers.portal.')->group(base_path('routes/tenant/customers.php'));
    }

    public function webRoutes()
    {
        Route::domain($this->appUrl())
            ->middleware('web')
            ->group(base_path('routes/web.php'));
    }

    public function globalRoutes()
    {
        Route::middleware('web')
            ->group(function () {
                /**
                 * Language Store Route
                 */
                Route::post('/language', \SAAS\Http\Languages\Controller\LanguageStoreController::class)->name('language.store');
            });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
