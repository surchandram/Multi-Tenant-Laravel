<?php

use Illuminate\Support\Facades\Route;

/*
 * ------------------------------------------------------------------
 * Place all your 'tenant' routes here
 * ------------------------------------------------------------------
 *
 * You can configure these routes in the 'tenancy' config file.
 *
 * The current tenant is available through `$request->tenant()`.
 *
 * --
 * Available middleware:
 * --
 *
 * For tenant feature setup on the fly or updating:
 * `team_feature.setup:{feature},{onFly}`; feature<string>, onFly<bool, true>
 *
 * Usage:
 * --
 * Route::middleware(['team_feature.setup:crm'])
 *  ->get('/apps/crm', \SAAS\Http\Tenant\Controllers\CrmController::class)
 *  ->name('crm.index');
 * --
 *
 * For tenant plan limit check:
 * `team_plan.maxed:{team},{feature}`; team<int|string|null>, feature<string>
 */

/**
 * Tenant Home Route
 */
Route::get('/', \SAAS\Http\Tenant\Controllers\HomeController::class)
    ->middleware('tenant.guest')
    ->withoutMiddleware(['auth', 'tenant'])
    ->name('index');

/**
 * Tenant Dashboard Route
 */
Route::get('/home', \SAAS\Http\Tenant\Controllers\DashboardController::class)->name('home');

/**
 * Documents Resource Route
 */
Route::resource('/documents', \SAAS\Http\Tenant\Controllers\Documents\Inertia\DocumentController::class);
