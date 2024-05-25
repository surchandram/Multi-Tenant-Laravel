<?php

use Illuminate\Support\Facades\Route;

/**
 * Dashboard Route
 */
Route::get('/', \SAAS\Http\Tenant\Controllers\Customers\DashboardController::class)->name('dashboard');

/**
 * Auth Group Routes
 */
Route::prefix('auth')->name('auth.')->withoutMiddleware(['customer', 'auth.customer'])->group(function () {

    /**
     * Project Invitation Callback Route
     */
    Route::get('/invitation/{userInvitation:identifier}/callback/project/{project:id}', [
        \SAAS\Http\Tenant\Controllers\Customers\Auth\CustomerProjectInvitationCallbackController::class, 'callback',
    ])->name('invitation.project.callback')->withoutScopedBindings();

    /**
     * Project Invitation Handle Route
     */
    Route::get('/invitation/{userInvitation:identifier}/project/{project:id}/handle', [
        \SAAS\Http\Tenant\Controllers\Customers\Auth\CustomerProjectInvitationCallbackController::class, 'show',
    ])->name('invitation.project.auth-form')->withoutScopedBindings()->middleware(['guest.customer']);

    /**
     * Email Verification Prompt Route
     */
    Route::get('/verification/notice', \SAAS\Http\Tenant\Controllers\Customers\Auth\EmailVerificationPromptController::class)
        ->name('verification.notice');

    /**
     * Login Route
     */
    Route::get('/login', \SAAS\Http\Tenant\Controllers\Customers\Auth\AuthenticateCustomerFormController::class)
        ->name('login')->middleware(['guest.customer']);

    /**
     * Login Route
     */
    Route::post('/login', \SAAS\Http\Tenant\Controllers\Customers\Auth\AuthenticateCustomerSessionController::class)
        ->middleware(['guest.customer']);
    /**
     * Register Route
     */
    Route::post('/register', \SAAS\Http\Tenant\Controllers\Customers\Auth\RegisterCustomerStoreController::class)
        ->name('register')->middleware(['guest.customer']);
});

/**
 * Projects Group Routes
 */
Route::prefix('projects')->group(function () {

    /**
     * Project Routes
     */
    Route::prefix('/{project}')->group(function () {

        /**
         * Project Work Authorization Store Route
         */
        Route::post('/work-authorization', \SAAS\Http\Tenant\Controllers\Customers\Projects\ProjectAuthorizationStoreController::class)
            ->name('projects.work-authorization.store');

        /**
         * Project Reschedule Store Route
         */
        Route::post('/reschedule', \SAAS\Http\Tenant\Controllers\Customers\Projects\ProjectRescheduleStoreController::class)
            ->name('projects.reschedule.store');
    });
});

/**
 * Projects Resource Routes
 */
Route::apiResource('/projects', \SAAS\Http\Tenant\Controllers\Customers\Projects\ProjectController::class)->except('store')->middleware([
    'verified:tenant.customers.portal.auth.verification.notice',
]);
