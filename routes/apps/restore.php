<?php

use Illuminate\Support\Facades\Route;
use SAAS\App\Support\Saas;
use SAAS\Domain\WebApps\Enums\Apps\Restore;
use SAAS\Http\Middleware\Company\RedirectIfAppNotSetup;
use SAAS\Http\Middleware\Company\RedirectIfStripeNotEnabled;

/*
 * ------------------------------------------------------------------
 * Register routes for the 'restore' app here
 * ------------------------------------------------------------------
 *
/**
 * App Home
 */

Route::get('/', \SAAS\Http\WebApps\Controllers\Restore\HomeController::class)->name('home');

/**
 * Protected Routes.
 */
Route::middleware([
    'auth',
    ...Saas::tenantMiddlewares(),
    RedirectIfAppNotSetup::class.':'.Restore::APP_KEY->value,
    RedirectIfStripeNotEnabled::class.':true',
])
    ->group(function () {

        /**
         * Threads Resource Routes.
         */
        Route::prefix('threads/{thread}')->as('threads.')->group(function () {

            /**
             * Messages Resource Routes.
             */
            Route::apiResource('messages', \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\MessageController::class)
                ->except('index', 'show');
        });

        /**
         * Moisture Map Reading Destroy Route
         */
        Route::delete(
            'moisture-map/{moistureMap}/readings/{reading}',
            \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\MoistureMapReadingDestroyController::class
        )->name('moisture-map.readings.destroy');

        /**
         * Projects Group Routes
         */
        Route::group([
            'prefix' => '/projects',
            'as' => 'projects.',
        ], function () {

            /**
             * Project Group Routes
             */
            Route::group(['prefix' => '/{project}'], function () {
                /**
                 * Project Logs Route
                 */
                Route::apiResource(
                    'logs',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectLogController::class
                )->parameters([
                    'logs' => 'projectLog',
                ]);

                /**
                 * Project Authorization Index Route
                 */
                Route::get(
                    'authorization',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectAuthorizationIndexController::class
                )->name('authorization.index');

                /**
                 * Project Authorization Store Route
                 */
                Route::post(
                    'authorization',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectAuthorizationStoreController::class
                )->name('authorization.store');

                /**
                 * Project Status Update Route
                 */
                Route::post(
                    'status',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectStatusUpdateController::class
                )->name('status.update');

                /**
                 * Project Customer Invitation Route
                 */
                Route::post(
                    'invitations/customer',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectCustomerInvitationController::class
                )->name('invitations.customer.store');

                /**
                 * Project Report Setup Route
                 */
                Route::get(
                    'reports/setup',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectReportSetupController::class
                )->name('reports.setup');

                /**
                 * Project Report Generator Route
                 */
                Route::get(
                    'reports/generate',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectReportGeneratorController::class
                )->name('reports.generate');

                /**
                 * Project Psychrometric Report Readings Store Route
                 */
                Route::post(
                    'psychrometric-report/readings',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\PsychrometricReportReadingsStoreController::class
                )->name('psychrometric-report.readings.store');

                /**
                 * Project Psychrometric Report Devices Store Route
                 */
                Route::post(
                    'psychrometric-report/devices',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\PsychrometricReportDeviceSetupController::class
                )->name('psychrometric-report.devices.store');

                /**
                 * Project Psychrometric Report Index Route
                 */
                Route::get(
                    'psychrometric-report',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\PsychrometricReportIndexController::class
                )->name('psychrometric-report.index');

                /**
                 * Project Moisture Map Index Route
                 */
                Route::get(
                    'moisture-map',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectMoistureMapIndexController::class
                )->name('moisture-map.index');

                /**
                 * Project Moisture Map Store Route
                 */
                Route::post(
                    'moisture-map',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectMoistureMapStoreController::class
                )->name('moisture-map.store');

                /**
                 * Project Moisture Map Devices Store Route
                 */
                Route::post(
                    'moisture-map/{moistureMap}/devices',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectMoistureMapDeviceSetupController::class
                )->name('moisture-map.devices.store');

                /**
                 * Project Moisture Map Readings Store Route
                 */
                Route::post(
                    'moisture-map/{moistureMap}/readings',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectMoistureMapReadingsStoreController::class
                )->name('moisture-map.readings.store');

                /**
                 * Project Moisture Map Destroy Route
                 */
                Route::delete(
                    'moisture-map/{moistureMap}',
                    \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectMoistureMapDestroyController::class
                )->name('moisture-map.destroy');
            });
        });

        /**
         * Projects Resource Routes
         */
        Route::resource('/projects', \SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects\ProjectController::class);
    });
