<?php

namespace SAAS\Domain\Companies\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use SAAS\App\Support\Roles;
use SAAS\Domain\Companies\Events\CompanyCreated;
use SAAS\Domain\Users\Models\Role;

class SeedCompanyRoles implements ShouldQueue
{
    use InteractsWithQueue;

    public $afterCommit = true;

    /**
     * A list of default company roles.
     *
     * @var array
     */
    public $roles;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->roles = Roles::teamRolesMap();
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(CompanyCreated $event)
    {
        $company = $event->company;

        foreach ($this->roles as $slug => $role) {
            $role = Role::whereSlug($slug)->first();

            if (! $role) {
                return;
            }

            $company->newRole($role);
        }
    }
}
