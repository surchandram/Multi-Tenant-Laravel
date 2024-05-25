<?php

namespace SAAS\App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use SAAS\App\Breadcrumbs\AdminBreadcrumbs;
use SAAS\App\Breadcrumbs\Breadcrumbs;
use SAAS\App\Support\Settings;
use SAAS\App\Support\SiteManager;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Pages\Repositories\Eloquent\PageRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['settings.manager']->extend('database', function ($app) {
            return new Settings($app);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Request::macro('breadcrumbs', function () {
            return new Breadcrumbs($this);
        });

        Request::macro('adminBreadcrumbs', function () {
            return new AdminBreadcrumbs($this);
        });

        $this->app->singleton(SiteManager::class, function ($app) {
            $pageRepository = $app->get(PageRepository::class);

            return new SiteManager(
                $pageRepository->findFirstSilently('name', SiteManager::PAGE_NAME)
            );
        });

        Route::bind('tenant_domain', fn ($value) => Company::where('domain', $value)->firstOrFail());

        // $this->app->singleton(UserRelationshipObserver::class, function () {
        //     return new UserRelationshipObserver(auth()->user());
        // });
    }
}
