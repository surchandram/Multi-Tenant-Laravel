<?php

namespace SAAS\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \SAAS\Http\Middleware\TrustHosts::class,
        \SAAS\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \SAAS\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \SAAS\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \SAAS\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \SAAS\Http\Middleware\SetLanguage::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \SAAS\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \SAAS\Http\Middleware\Admin\Impersonate::class,
            \SAAS\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \SAAS\Http\Middleware\Authenticate::class,
        'auth.customer' => \SAAS\Http\Middleware\AuthenticateCustomer::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \SAAS\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \SAAS\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'scopes' => \Laravel\Passport\Http\Middleware\CheckScopes::class,
        'scope' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
        'subscription.active' => \SAAS\Http\Middleware\Subscription\RedirectIfNotActive::class,
        'subscription.notcancelled' => \SAAS\Http\Middleware\Subscription\RedirectIfCancelled::class,
        'subscription.cancelled' => \SAAS\Http\Middleware\Subscription\RedirectIfNotCancelled::class,
        'subscription.customer' => \SAAS\Http\Middleware\Subscription\RedirectIfNotCustomer::class,
        'subscription.inactive' => \SAAS\Http\Middleware\Subscription\RedirectIfNotInactive::class,
        'in_team' => \SAAS\Http\Middleware\Company\AbortIfNotInCompany::class,
        'team_subscription.active' => \SAAS\Http\Middleware\Company\Subscription\RedirectIfNotActive::class,
        'team_subscription.notcancelled' => \SAAS\Http\Middleware\Company\Subscription\RedirectIfCancelled::class,
        'team_subscription.cancelled' => \SAAS\Http\Middleware\Company\Subscription\RedirectIfNotCancelled::class,
        'team_subscription.customer' => \SAAS\Http\Middleware\Company\Subscription\RedirectIfNotCustomer::class,
        'team_subscription.inactive' => \SAAS\Http\Middleware\Company\Subscription\RedirectIfNotInactive::class,
        'team_feature.setup' => \SAAS\Http\Middleware\Company\HandleFeatureSetup::class,
        'team_plan.maxed' => \SAAS\Http\Middleware\Company\RedirectIfPlanMaxed::class,
        'customer' => \SAAS\Http\Middleware\Customer\RedirectIfNotCustomer::class,
        'guest.customer' => \SAAS\Http\Middleware\RedirectIfCustomerAuthenticated::class,
    ];
}
