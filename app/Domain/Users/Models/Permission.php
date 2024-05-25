<?php

namespace SAAS\Domain\Users\Models;

use Miracuthbert\LaravelRoles\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    /**
     * Get the model's breadcrumb name.
     *
     * @return mixed
     */
    public function breadcrumbName()
    {
        return $this->name;
    }
}
