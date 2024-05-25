<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Home Route
 */
Route::get('/', [\SAAS\Http\Home\Controllers\HomeController::class, 'index'])->name('home');

// Socialite routes
Route::get('/public/{provider}/redirect', [\SAAS\Http\Auth\Controllers\SocialiteController::class, 'redirect'])->name('login.social');
Route::get('/googlelogin/public/{provider}/callback', [\SAAS\Http\Auth\Controllers\SocialiteController::class, 'callback']);

/**
 * Apps Routes
 */
Route::resource('/apps', \SAAS\Http\WebApps\Controllers\AppController::class)->only('index', 'show');

/**
 * Docs Route
 */
Route::get('/docs/{file?}', [\SAAS\Http\Docs\Controllers\DocsController::class, 'index'])->name('docs.index');

/**
 * Support Routes
 */
Route::prefix('/support')->as('support.')->group(function () {
    Route::get('/tickets/filters', \SAAS\Http\Support\Controllers\TicketFiltersController::class)
        ->name('tickets.filters.index');
    /**
     * Ticket Messages Store Route
     */
    Route::post('/tickets/{ticket}/messages', \SAAS\Http\Support\Controllers\TicketMessageStoreController::class)->name('tickets.messages.store');

    /**
     * Tickets Resource Routes
     */
    Route::resource('/tickets', \SAAS\Http\Support\Controllers\TicketController::class);
});

/**
 * Developers Routes
 */
Route::resource('/developers', \SAAS\Http\Developers\Controllers\DeveloperController::class)->only('index');

/**
 * TOS and Privacy Policy Routes
 */
Route::get('/terms-of-service', [\SAAS\Http\Site\Controllers\TermsOfServiceController::class, 'show'])->name('terms.show');
Route::redirect('/terms-of-service', config('app.site_url').'/terms-and-conditions/');
Route::get('/privacy-policy', [\SAAS\Http\Site\Controllers\PrivacyPolicyController::class, 'show'])->name('policy.show');
Route::redirect('/privacy-policy', config('app.site_url').'/privacy-policy/');

/**
 * Plans Routes
 */
Route::group(['middleware' => ['subscription.inactive']], function () {
    /**
     * Team Plans Route
     */
    Route::get('/plans/teams', \SAAS\Http\Plans\Controllers\PlanTeamController::class)->name('plans.teams.index');

    /**
     * Plans Resource Routes
     */
    Route::resource('/plans', \SAAS\Http\Plans\Controllers\PlanController::class)->only('index', 'show');
});

/**
 * Guest Routes
 */
Route::group(['middleware' => ['guest']], function () {
    /**
     * Additional Login Group Routes
     */
    Route::group(['prefix' => '/login', 'as' => 'login.'], function () {
        /**
         * Two Factor Routes
         */
        Route::resource('twofactor', \SAAS\Http\Auth\Controllers\TwoFactorLoginController::class)->only('index', 'store');
    });
});

/**
 * Dashboard Route
 */
Route::get('/dashboard', \SAAS\Http\Dashboard\Controllers\DashboardController::class)->name('dashboard');

/**
 * Account Routes
 */
Route::group(
    ['prefix' => '/account', 'as' => 'account.', 'middleware' => ['auth', 'verified']],
    function () {
        /**
         * Account Overview
         */
        Route::get('/', \SAAS\Http\Account\Controllers\AccountController::class)->name('index');

        /**
         * Address Resource Routes
         */
        Route::resource('/addresses', \SAAS\Http\Addresses\Controllers\AddressController::class);

        /**
         * Profile Routes
         */
        Route::resource('/profile', \SAAS\Http\Account\Controllers\ProfileController::class)->only('index', 'store');

        /**
         * Password Routes
         */
        Route::resource('/password', \SAAS\Http\Account\Controllers\PasswordController::class)->only('index', 'store');

        /**
         * TwoFactor Routes
         */
        Route::post('/twofactor/verify', [\SAAS\Http\Account\Controllers\TwoFactorController::class, 'verify'])->name('twofactor.verify');
        Route::delete('/twofactor', [\SAAS\Http\Account\Controllers\TwoFactorController::class, 'destroy'])->name('twofactor.destroy');
        Route::resource('/twofactor', \SAAS\Http\Account\Controllers\TwoFactorController::class)->only('index', 'store');

        /**
         * Deactivation Routes
         */
        Route::resource('/deactivate', \SAAS\Http\Account\Controllers\DeactivateController::class)->only('index', 'store');

        /**
         * Subscriptions Group Routes
         */
        Route::group(['prefix' => '/subscriptions', 'as' => 'subscriptions.', 'middleware' => []], function () {
            /**
             * Subscription Invoice Download Route
             */
            Route::get('/invoices/{invoice}', \SAAS\Http\Account\Controllers\Subscriptions\SubscriptionInvoiceDownloadController::class)
                ->name('invoice.download');

            /**
             * Subscription Swap Routes
             */
            Route::resource('/swap', \SAAS\Http\Account\Controllers\Subscriptions\SubscriptionSwapController::class)->only('index', 'store');

            /**
             * Subscription Cancel Routes
             */
            Route::resource('/cancel', \SAAS\Http\Account\Controllers\Subscriptions\SubscriptionCancelController::class)->only('index', 'store');

            /**
             * Subscription Resume Routes
             */
            Route::resource('/resume', \SAAS\Http\Account\Controllers\Subscriptions\SubscriptionResumeController::class)->only('index', 'store');

            /**
             * Subscription Payment Methods Routes
             */
            Route::resource('/payment-methods', \SAAS\Http\Account\Controllers\Subscriptions\SubscriptionPaymentMethodController::class)->only('index', 'store');
        });

        /**
         * Subscriptions Resource Routes
         */
        Route::resource('/subscriptions', \SAAS\Http\Account\Controllers\Subscriptions\SubscriptionController::class)->only('index', 'store');

        /**
         * API Token Management Route
         */
        Route::get('/tokens', \SAAS\Http\Account\Controllers\APITokenController::class)->name('tokens.index');
    }
);

/**
 * Webhooks Routes
 */
Route::group(['prefix' => '/webhooks'], function () {
    /**
     * Stripe Webhook Route
     */
    Route::post('/stripe', [\SAAS\Http\Webhooks\Controllers\StripeWebhookController::class, 'handleWebhook']);
});

/**
 * Users Impersonate Destroy Route
 */
Route::delete('/impersonate', [\SAAS\Http\Admin\Controllers\Users\UserImpersonateController::class, 'destroy'])->name('admin.users.impersonate.destroy');

/**
 * Apps Filters Route
 */
Route::get('/apps/filters', \SAAS\Http\WebApps\Controllers\AppFiltersController::class)->name('apps.filters.index');

/**
 * Invitations Routes
 */
Route::group(['prefix' => '/auth/invitations', 'as' => 'auth.invitations.'], function () {
    /**
     * Invitation Route
     */
    Route::group(['prefix' => '/{userInvitation}'], function () {
        /**
         * Invitation Accept (Existing Users) Route
         */
        Route::get('/accept/existing', \SAAS\Http\Auth\Controllers\InvitationAcceptExistingController::class)
            ->name('accept.existing')
            ->middleware(['auth']);

        /**
         * Invitation Accept Route
         */
        Route::get('/accept', \SAAS\Http\Auth\Controllers\InvitationAcceptController::class)->name('accept');
    });
});

require __DIR__.'/auth.php';
