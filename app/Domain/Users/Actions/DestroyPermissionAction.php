<?php

namespace SAAS\Domain\Users\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Users\Models\Permission;

class DestroyPermissionAction
{
    public static function execute(Permission $permission): ?bool
    {
        try {
            $deleted = DB::transaction(function () use ($permission) {
                return $permission->delete();
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $deleted;
    }
}
