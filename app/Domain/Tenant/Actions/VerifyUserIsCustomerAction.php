<?php

namespace SAAS\Domain\Tenant\Actions;

use Miracuthbert\Multitenancy\Models\Tenant;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Users\Models\User;

class VerifyUserIsCustomerAction
{
    public static function execute(User $user, Tenant $tenant): bool
    {
        try {
            return Project::whereOwnedByUser($user)->count() > 0;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
