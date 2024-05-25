<?php

namespace SAAS\View\Composers;

use SAAS\Domain\Users\Models\Permission;
use Illuminate\View\View;

class PermissionsComposer
{
    /**
     * Permissions.
     *
     * @var $permissions
     */
    private $permissions;

    /**
     * Share roles.
     *
     * @param View $view
     * @return View
     */
    public function compose(View $view)
    {
        if (!$this->permissions) {
            $this->permissions = Permission::active()->get();
        }

        return $view->with('permissions', $this->permissions);
    }
}
