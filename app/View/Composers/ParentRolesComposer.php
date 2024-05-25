<?php

namespace SAAS\View\Composers;

use SAAS\Domain\Users\Models\Role;
use Illuminate\View\View;

class ParentRolesComposer
{
    /**
     * Roles.
     *
     * @var $roles
     */
    private $roles;

    public function compose(View $view)
    {
        if (!$this->roles) {
            $this->roles = Role::whereDoesntHave('parent')->whereDoesntHave('users')->get();
        }

        return $view->with('roles', $this->roles);
    }
}
