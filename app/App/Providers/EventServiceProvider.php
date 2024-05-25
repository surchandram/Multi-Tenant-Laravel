<?php

namespace SAAS\App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Miracuthbert\Multitenancy\Events\TenantIdentified;
use SAAS\Domain\Companies\Events\CompanyCreated;
use SAAS\Domain\Companies\Listeners\CreateStripeAccount;
use SAAS\Domain\Companies\Listeners\PresetCompanyApps;
use SAAS\Domain\Companies\Listeners\SeedCompanyRoles;
use SAAS\Domain\Restore\Events\Projects\ProjectApprovedEvent;
use SAAS\Domain\Restore\Listeners\Projects\Approved\AddProjectToSchedulerListener;
use SAAS\Domain\Restore\Listeners\Projects\Approved\SendApprovedNotificationsListener;
use SAAS\Domain\Tenant\Events\SetupTenantFeature;
use SAAS\Domain\Tenant\Listeners\HandleFeatureSetup;
use SAAS\Domain\Tenant\Listeners\HandleFeaturesSetup;
use SAAS\Domain\Users\Events\SendUserInvitation;
use SAAS\Domain\Users\Listeners\SendUserInvitationMail;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SendUserInvitation::class => [
            SendUserInvitationMail::class,
        ],
        CompanyCreated::class => [
            SeedCompanyRoles::class,
            PresetCompanyApps::class,
            CreateStripeAccount::class,
        ],
        TenantIdentified::class => [
            // HandleFeaturesSetup::class,
        ],
        SetupTenantFeature::class => [
            HandleFeatureSetup::class,
        ],
        ProjectApprovedEvent::class => [
            SendApprovedNotificationsListener::class,
            AddProjectToSchedulerListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
