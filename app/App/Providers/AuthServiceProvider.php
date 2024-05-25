<?php

namespace SAAS\App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'SAAS\Models\Model' => 'SAAS\Policies\ModelPolicy',
        'Saasplayground\SupportTickets\Tickets\Models\Ticket' => 'SAAS\Domain\Tickets\Policies\TicketPolicy',
        'SAAS\Domain\Tickets\Models\Ticket' => 'SAAS\Domain\Tickets\Policies\TicketPolicy',
        'SAAS\Domain\WebApps\Models\AppFeature' => 'SAAS\Domain\WebApps\Policies\AppFeaturePolicy',
        'SAAS\Domain\WebApps\Models\App' => 'SAAS\Domain\WebApps\Policies\AppPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        \Laravel\Passport\Passport::tokensCan([
            'create-team' => 'Create Team',
            'update-team' => 'Update Team',
            'add-team-members' => 'Add Team Members',
            // 'create-projects' => 'Create Projects',
            // 'delete-projects' => 'Delete Projects',
            // 'create-edit-pages' => 'Create and Edit Pages',
            // 'create-edit-posts' => 'Create and Edit Posts',
        ]);
    }
}
