<?php

namespace SAAS\App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use SAAS\Domain\WebApps\Models\App;
use SAAS\View\Composers\ParentRolesComposer;
use SAAS\View\Composers\PermissionsComposer;
use SAAS\View\Composers\PlansComposer;
use SAAS\View\Composers\RoleAndPermissionTypesComposer;
use SAAS\View\Composers\RolesComposer;
use SAAS\View\Composers\UserFiltersComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // apps
        View::composer([
            'layouts.navigation',
            'layouts.simple',
            'teams.create',
            'dashboard',
        ], function ($view) {
            $view->with('webApps', App::with('media')->active()->defaultOrder()->get());
        });

        View::composer([
            'subscriptions.index',
        ], PlansComposer::class);

        // permissions
        View::composer([
            'admin.permissions.partials.forms._permissions',
            'layouts.partials.forms._permissions',
        ], PermissionsComposer::class);

        // role and permission types
        View::composer('admin.layouts.partials.forms._permitables', RoleAndPermissionTypesComposer::class);

        // parent roles
        View::composer('admin.roles.partials.forms._parent_roles', ParentRolesComposer::class);

        // features
        // View::composer('home', FeaturesComposer::class);

        //user filters mappings
        View::composer([
            'admin.users.partials._filters',
        ], UserFiltersComposer::class);

        //roles list
        View::composer([
            'admin.roles.partials.forms._roles',
            'admin.users.roles.partials.forms._roles',
            'admin.users.user.roles.index',
            'admin.users.create',
        ], RolesComposer::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserCompaniesComposer::class);
    }
}
