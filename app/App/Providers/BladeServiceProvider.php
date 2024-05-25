<?php

namespace SAAS\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //user is subscribed
        Blade::if ('impersonating', function () {
            return session()->has('impersonate');
        });

        //user is subscribed
        Blade::if ('subscribed', function ($subscription = 'main') {
            return auth()->user()->hasSubscription($subscription);
        });

        //user does not have subscription
        Blade::if ('notsubscribed', function ($subscription = 'main') {
            return !auth()->check() || optional(auth()->user())->hasNoSubscription($subscription);
        });

        //user has cancelled subscription
        Blade::if ('subscriptioncancelled', function ($subscription = 'main') {
            return auth()->user()->hasCancelled($subscription);
        });

        //user has not cancelled subscription
        Blade::if ('subscriptionnotcancelled', function ($subscription = 'main') {
            return auth()->user()->hasNotCancelled($subscription);
        });

        //user has a team subscription
        Blade::if ('teamsubscription', function () {
            return auth()->user()->hasTeamSubscription();
        });

        //user does not have a piggyback subscription
        Blade::if ('notpiggybacksubscription', function () {
            return !auth()->user()->hasPiggybackSubscription();
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
