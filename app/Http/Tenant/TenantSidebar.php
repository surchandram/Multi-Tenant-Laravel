<?php

namespace SAAS\Http\Tenant;

use SAAS\Domain\WebApps\Enums\Apps\Restore;
use Spatie\Navigation\Facades\Navigation;
use Spatie\Navigation\Section;

class TenantSidebar
{
    public static function getSidebar($request)
    {
        if (! ($tenant = $request->tenant())) {
            return [];
        }

        $apps = $tenant->apps->load('app');

        return Navigation::make()
            ->add(
                'Dashboard',
                ! $request->routeIs('tenant.home') ? route('tenant.switch', $tenant->id) : route('tenant.home'),
                fn ($section) => $section->attributes([
                    'native' => ! $request->routeIs('tenant.home'),
                    'icon' => 'home',
                ])
            )
            ->addIf(
                $apps->contains(fn ($app) => $app->app->key === Restore::APP_KEY->value),
                'Restore',
                route('restore.projects.index'),
                function (Section $section) use ($request, $tenant) {
                    $resolved = $section
                        ->attributes([
                            'icon' => 'briefcase-business',
                            'native' => ! $request->routeIs('restore.*'),
                        ]);

                    if ($tenant && $request->routeIs('restore.*')) {
                        $resolved
                            ->add('New Project', route('restore.projects.create'))
                            ->add('Projects', route('restore.projects.index'));
                    }

                    return $resolved;
                }
            )
            ->add(
                'Manage Apps',
                route('companies.apps.index', $tenant->id),
                fn ($section) => $section->attributes([
                    'native' => true,
                    'icon' => 'layout-grid',
                ])
            )->tree();
    }
}
