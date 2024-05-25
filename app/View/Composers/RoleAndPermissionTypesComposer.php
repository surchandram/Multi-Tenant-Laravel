<?php

namespace SAAS\View\Composers;

use Illuminate\View\View;

class RoleAndPermissionTypesComposer
{
    /**
     * Permitted types.
     *
     * @var $types
     */
    private $types;

    /**
     * Share permission types.
     *
     * @param View $view
     * @return View
     */
    public function compose(View $view)
    {
        if (!$this->types) {
            $this->types = config('laravel-roles.permitables');
        }

        return $view->with('types', $this->types);
    }
}
