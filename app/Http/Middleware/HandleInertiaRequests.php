<?php

namespace SAAS\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Middleware;
use Laraeast\LaravelSettings\Facades\Settings;
use SAAS\App\Pages\Components\PageComponentsMapper;
use SAAS\App\Pages\DataObjects\PageData;
use SAAS\App\Support\SiteManager;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use SAAS\Http\Tenant\TenantSidebar;
use SAAS\Lang\Actions\GetLocaleTranslationsAction;
use SAAS\Lang\Lang;
use SAAS\Lang\LangData;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'spa';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request): array
    {
        $loggedIn = auth()->check();

        $logoData = SiteManager::make()->getLogoData();

        $pageData = $request->routeIs('admin.*') ? [] : [
            'pageData' => ($page = PageData::make($request->route()->getName())->value()),
            'page_components' => $page ? PageComponentsMapper::mapped($page->page_components) : [],
        ];

        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'appTagline' => Settings::get('tagline', 'Your Amazing Startup'),
            'title' => Settings::get('title', config('app.name')),
            'subtitle' => Settings::get('subtitle', 'Your Amazing Startup'),
            'appDomain' => parse_url(env('APP_URL'), PHP_URL_HOST),
            'settings' => setting()->all(),
            'logoData' => empty($logoData) ? [] : $logoData,
            'flash' => Arr::only($request->session()->all(), [
                'flash', 'success', 'error', 'info', 'warning',
            ]),
            'notification' => collect(Arr::only($request->session()->all(), [
                'success', 'error', 'info', 'warning', 'notice',
            ]))->mapWithKeys(fn ($notification, $key) => [
                'type' => $key,
                'body' => $notification,
            ]),
            'auth' => [
                'loggedIn' => $loggedIn,
                'impersonating' => session()->has('impersonate'),
                'canBrowseAdmin' => $loggedIn ? $request->user()->can('browse admin') : false,
                'user' => $loggedIn ? UserData::fromModel(
                    $request->user()->loadMissing('companies.media')
                ) : null,
                'permissions' => $loggedIn ? $request->user()->validPermissions() : [],
                'permissions_collection' => $loggedIn ? $request->user()->getAllPermissions() : [],
                'roles' => $loggedIn ? $request->user()->getUserRoles() : [],
            ],
            'tenant' => ! ($tenant = $request->tenant()) ? [] : function () use ($tenant) {
                tenancy()->runNonTenantTask(function () use (&$tenant) {
                    $tenant->loadMissing([
                        'addresses.country',
                        'media',
                    ]);
                });

                return $tenant;
            },
            'tenant_routes' => [
                'sidebar' => TenantSidebar::getSidebar($request),
            ],
            'language' => app()->getLocale(),
            'languages' => LangData::collection(Lang::cases()),
            'translations' => fn () => GetLocaleTranslationsAction::execute(app()->getLocale()),
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'csrf_token' => csrf_token(),
        ], $pageData);
    }
}
