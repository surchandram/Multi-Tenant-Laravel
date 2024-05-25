<?php

namespace SAAS\App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use SAAS\Domain\Users\Models\User;
use Stripe\Stripe;
use Stripe\StripeClient;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Cashier::useCustomerModel(User::class);
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('stripe', fn () => new StripeClient(config('services.stripe.secret')));
    }
}
