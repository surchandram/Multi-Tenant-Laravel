<?php

namespace SAAS\App\Providers;

use Illuminate\Support\ServiceProvider;
use SAAS\App\Payments\Gateway;
use SAAS\App\Payments\Gateways\StripeGateway;

class PaymentGatewayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $this->app->singleton(Gateway::class, function ($app) {
            return new StripeGateway();
        });
    }
}
