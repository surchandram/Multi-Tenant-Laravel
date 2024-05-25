<?php

use Illuminate\Support\Facades\Route;

/**
 * Companies Group Routes
 */
Route::group(['prefix' => '/companies', 'as' => 'companies.'], function () {
    /**
     * Company Group Routes
     */
    Route::group(['prefix' => '/{company}'], function () {

        /**
         * Apps Group Routes
         */
        Route::group(['prefix' => '/apps', 'as' => 'apps.'], function () {

            /**
             * Apps Index Route
             */
            Route::get('/', \SAAS\Http\Companies\Controllers\CompanyAppsIndexController::class)->name('index')
                ->withoutScopedBindings();

            Route::group(['prefix' => '/{app:key}'], function () {

                /**
                 * App Settings Index Route
                 */
                Route::get('settings', [\SAAS\Http\Companies\Controllers\CompanyAppsSettingsController::class, 'index'])->name('settings.index')
                    ->withoutScopedBindings();

                /**
                 * App Settings Store Route
                 */
                Route::post('settings', [\SAAS\Http\Companies\Controllers\CompanyAppsSettingsController::class, 'store'])->name('settings.store')
                    ->withoutScopedBindings();

                /**
                 * App Setup Index Route
                 */
                Route::get('setup', [\SAAS\Http\Companies\Controllers\CompanyAppSetupController::class, 'index'])->name('setup.index')
                    ->withoutScopedBindings();

                /**
                 * App Setup Store Route
                 */
                Route::post('setup', [\SAAS\Http\Companies\Controllers\CompanyAppSetupController::class, 'store'])->name('setup.store')
                    ->withoutScopedBindings();
            });
        });

        /**
         * Onboarding Routes
         */
        Route::group(['prefix' => '/onboarding', 'as' => 'onboarding.'], function () {

            /**
             * Stripe Onboarding Routes
             */
            Route::get('/stripe', [\SAAS\Http\Companies\Controllers\StripeOnboardingController::class, 'index'])->name('stripe.index');
            Route::get('/stripe/redirect', [\SAAS\Http\Companies\Controllers\StripeOnboardingController::class, 'redirect'])->name('stripe.redirect');
            Route::get('/stripe/verify', [\SAAS\Http\Companies\Controllers\StripeOnboardingController::class, 'verify'])->name('stripe.verify');
        });

        /**
         * Company Domain Routes
         */
        Route::get('/domain', [\SAAS\Http\Companies\Controllers\CompanyDomainController::class, 'index'])->name('domain.index');
        Route::post('/domain', [\SAAS\Http\Companies\Controllers\CompanyDomainController::class, 'store'])->name('domain.store');

        /**
         * Team User Store Route
         */
        Route::post('/teams/users/store', \SAAS\Http\Companies\Controllers\Teams\TeamUserStoreController::class)
            ->name('teams.users.store');

        /**
         * Teams Resource Routes
         */
        Route::resource('/teams', \SAAS\Http\Companies\Controllers\Teams\TeamController::class);

        /**
         * Address Resource Routes
         */
        Route::resource('/addresses', \SAAS\Http\Companies\Controllers\Addresses\AddressController::class);

        /**
         * Company Logo Store Route
         */
        Route::post('/logo', \SAAS\Http\Companies\Controllers\LogoUploadController::class)->name('logo.store');

        /**
         * Company Delete Route
         */
        Route::get('/delete', \SAAS\Http\Companies\Controllers\CompanyDeleteController::class)->name('delete');

        /**
         * Company User Role Edit Route
         */
        Route::get('/users/{user}/roles/edit', [\SAAS\Http\Companies\Controllers\CompanyUserRoleController::class, 'edit'])->name('users.roles.edit');

        /**
         * Company User Role Update Route
         */
        Route::patch('/users/{user}/roles', [\SAAS\Http\Companies\Controllers\CompanyUserRoleController::class, 'update'])->name('users.roles.update');

        /**
         * Company User Delete Route
         */
        Route::get('/users/{user}/delete', \SAAS\Http\Companies\Controllers\CompanyUserDeleteController::class)->name('users.delete');

        /**
         * Company Users Resource Routes
         */
        Route::resource('/users', \SAAS\Http\Companies\Controllers\CompanyUserController::class);

        /**
         * Company Role Status Route
         */
        Route::patch('/roles/{role}/status', \SAAS\Http\Companies\Controllers\CompanyRoleStatusController::class)->name('roles.status');

        /**
         * Company Roles Resource Routes
         */
        Route::resource('/roles', \SAAS\Http\Companies\Controllers\CompanyRoleController::class);

        /**
         * Company Subscriptions Routes
         */
        Route::group(['prefix' => '/subscriptions', 'as' => 'subscriptions.'], function () {
            /**
             * Company Subscriptions Swap Routes
             */
            Route::resource('/swap', \SAAS\Http\Companies\Controllers\Subscriptions\SubscriptionSwapController::class)->only('index', 'store');

            /**
             * Company Subscriptions Cancel Routes
             */
            Route::resource('/cancel', \SAAS\Http\Companies\Controllers\Subscriptions\SubscriptionCancelController::class)->only('index', 'store');

            /**
             * Company Subscriptions Resume Routes
             */
            Route::resource('/resume', \SAAS\Http\Companies\Controllers\Subscriptions\SubscriptionResumeController::class)->only('index', 'store');

            /**
             * Company Subscriptions Payment Methods Routes
             */
            Route::resource('/payment-methods', \SAAS\Http\Companies\Controllers\Subscriptions\SubscriptionPaymentMethodController::class)->only('index', 'store');
        });

        /**
         * Company Subscriptions Resource Routes
         */
        Route::resource('/subscriptions', \SAAS\Http\Companies\Controllers\Subscriptions\SubscriptionController::class)->only('index', 'store');
    });

    /**
     * Personal Company Create Route
     */
    Route::get('/personal/setup', \SAAS\Http\Companies\Controllers\PersonalCompanyCreateController::class)->name('personal.setup');
});

/**
 * Companies Resource Routes
 */
Route::resource('/companies', \SAAS\Http\Companies\Controllers\CompanyController::class);
