<?php

use Illuminate\Support\Facades\Route;

/**
 * Dashboard Route
 */
Route::get('dashboard', \SAAS\Http\Admin\Controllers\DashboardController::class)->name('dashboard');

/**
 * Company Resource Routes
 */
Route::resource('companies', \SAAS\Http\Admin\Controllers\Companies\CompanyController::class);

/**
 * Documents Resource Routes
 */
Route::resource('documents', \SAAS\Http\Admin\Controllers\Documents\DocumentController::class);

/**
 * Site Group Routes
 */
Route::prefix('/site')->as('site.')->group(function () {
    /**
     * Logo Index Route
     */
    Route::get('/logo', [\SAAS\Http\Admin\Controllers\Site\SiteLogoController::class, 'index'])
        ->name('logo.index');

    /**
     * Logo Store Route
     */
    Route::post('/logo', [\SAAS\Http\Admin\Controllers\Site\SiteLogoController::class, 'store'])
        ->name('logo.store');
});

/**
 * Pages Routes
 */
Route::prefix('/pages')->name('pages.')->group(function () {
    Route::prefix('/{page}')->group(function () {
        /**
         * Media Destroy Route
         */
        Route::delete('/media/{media}', \SAAS\Http\Admin\Controllers\Pages\MediaDestroyController::class)->name('media.destroy');

        /**
         * Image Store Route
         */
        Route::post('/image', [\SAAS\Http\Admin\Controllers\Pages\PageImageController::class, 'store'])->name('image.store');

        /**
         * Images Resource Routes
         */
        Route::resource('/images', \SAAS\Http\Admin\Controllers\Pages\PageImagesController::class);
    });
});

/**
 * Page Resource Routes
 */
Route::resource('/pages', \SAAS\Http\Admin\Controllers\Pages\PageController::class);

/**
 * Features Resource Routes
 */
Route::resource('/features', \SAAS\Http\Admin\Controllers\Features\FeatureController::class);

/**
 * Plans Group Routes
 */
Route::group(['prefix' => '/plans', 'as' => 'plans.'], function () {
    /**
     * Plan Group Routes
     */
    Route::group(['prefix' => '/{plan}'], function () {
        /**
         * Plan Features Resource Routes
         */
        Route::resource('/features', \SAAS\Http\Admin\Controllers\Plans\PlanFeatureController::class, [
            'parameters' => [
                'features' => 'planFeature',
            ],
        ]);

        /**
         * Plan Status Route
         */
        Route::middleware([
            'permission:update plan',
        ])->post('/status', \SAAS\Http\Admin\Controllers\Plans\PlanStatusController::class)->name('status');
    });
});

/**
 * Plans Resource Routes
 */
Route::resource('/plans', \SAAS\Http\Admin\Controllers\Plans\PlanController::class)->except('show');

/**
 * Users Group Routes
 */
Route::group(['prefix' => '/users', 'as' => 'users.'], function () {
    /**
     * Users Restore Routes
     */
    Route::resource('/restore', \SAAS\Http\Admin\Controllers\Users\UserRestoreController::class)->only('index', 'store');

    /**
     * User Impersonate Routes
     */
    Route::group(['prefix' => '/impersonate', 'as' => 'impersonate.'], function () {
        // index
        Route::get('/', [\SAAS\Http\Admin\Controllers\Users\UserImpersonateController::class, 'index'])->name('index');

        // store
        Route::post('/', [\SAAS\Http\Admin\Controllers\Users\UserImpersonateController::class, 'store'])->name('store');
    });

    /**
     * User Group Routes
     */
    Route::group(['prefix' => '/{user}'], function () {
        Route::resource('/roles', \SAAS\Http\Admin\Controllers\Users\UserRoleController::class, [
            'except' => [
                'show',
            ],
        ]);
    });
});

/**
 * Permissions Group Routes
 */
Route::group(['prefix' => '/permissions', 'as' => 'permissions.'], function () {
    /**
     * Role Group Routes
     */
    Route::group(['prefix' => '/{permission}'], function () {
        // toggle status
        Route::put('/status', \SAAS\Http\Admin\Controllers\Permissions\PermissionStatusController::class)->name('toggleStatus');
    });
});

/**
 * Permissions Resource Routes
 */
Route::resource('/permissions', \SAAS\Http\Admin\Controllers\Permissions\PermissionController::class);

/**
 * Roles Group Routes
 */
Route::group(['prefix' => '/roles', 'as' => 'roles.'], function () {
    /**
     * Role Group Routes
     */
    Route::group(['prefix' => '/{role}'], function () {
        // toggle status
        Route::put('/status', \SAAS\Http\Admin\Controllers\Roles\RoleStatusController::class)->name('toggleStatus');

        // revoke users access
        Route::put('/revoke', [\SAAS\Http\Admin\Controllers\Roles\RoleUsersDisableController::class, 'revokeUsersAccess'])->name('revokeUsersAccess');
    });
});

/**
 * Roles Resource Routes
 */
Route::resource('/roles', \SAAS\Http\Admin\Controllers\Roles\RoleController::class);

/**
 * Users Resource Routes
 */
Route::resource('/users', \SAAS\Http\Admin\Controllers\Users\UserController::class);

/**
 * Support Routes
 */
Route::prefix('/support')->as('support.')->group(function () {
    Route::prefix('/tickets')->as('tickets.')->group(function () {
        /**
         * Status Stats Route
         */
        Route::get('/stats/status', \SAAS\Http\Admin\Controllers\Support\TicketStatusStatController::class)->name('stats.status');

        /**
         * Categories Resource Routes
         */
        Route::resource('/categories', \SAAS\Http\Admin\Controllers\Support\TicketCategoryController::class);

        /**
         * Labels Resource Routes
         */
        Route::resource('/labels', \SAAS\Http\Admin\Controllers\Support\TicketLabelController::class);
    });

    /**
     * Ticket Agent (Assign) Store Route
     */
    Route::post('/tickets/{ticket}/agents', \SAAS\Http\Admin\Controllers\Support\TicketAssignAgentController::class)->name('tickets.agents.store')->middleware(['permission:assign ticket agent']);

    /**
     * Ticket Messages Store Route
     */
    Route::post('/tickets/{ticket}/messages', \SAAS\Http\Admin\Controllers\Support\TicketMessageStoreController::class)->name('tickets.messages.store');

    /**
     * Tickets Resource Routes
     */
    Route::resource('/tickets', \SAAS\Http\Admin\Controllers\Support\TicketController::class);
});

/**
 * Apps Routes
 */
Route::prefix('/apps')->as('apps.')->group(function () {

    /**
     * Restore Settings Routes
     */
    Route::get('/restore/projects/types/settings', [
        \SAAS\Http\Admin\Controllers\WebApps\Restore\ProjectTypeSettingsController::class,
        'index',
    ])->name('restore.projects.types.settings');

    Route::post('/restore/projects/types/settings', [
        \SAAS\Http\Admin\Controllers\WebApps\Restore\ProjectTypeSettingsController::class,
        'store',
    ])->name('restore.projects.types.settings.store');

    /**
     * App Routes
     */
    Route::prefix('/{app}')->group(function () {
        /**
         * App Logo Store Route
         */
        Route::post('/logo', \SAAS\Http\Admin\Controllers\WebApps\AppLogoController::class)
            ->name('logo.store');

        /**
         * App Features Routes
         */
        Route::resource('/features', \SAAS\Http\Admin\Controllers\WebApps\AppFeatureController::class, [
            'parameters' => [
                'features' => 'appFeature',
            ],
        ]);
    });
});

/**
 * Apps Resource Routes
 */
Route::resource('/apps', \SAAS\Http\Admin\Controllers\WebApps\AppController::class);

/**
 * Settings Resource Routes
 */
Route::resource('/settings', \SAAS\Http\Admin\Controllers\Settings\SettingController::class);
