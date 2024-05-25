<?php

namespace SAAS\View\Composers;

use SAAS\Domain\Users\Models\Role;
use Illuminate\View\View;

class RolesComposer
{
    /**
     * Roles.
     *
     * @var $roles
     */
    private $roles;

    /**
     * Share roles.
     *
     * @param View $view
     * @return View
     */
    public function compose(View $view)
    {
        if (!$this->roles) {
            $this->roles = Role::type('admin')->get()->toTree();
        }

        return $view->with('roles', $this->roles);
    }
}
