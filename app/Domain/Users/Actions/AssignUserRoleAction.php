<?php

namespace SAAS\Domain\Users\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Users\DataTransferObjects\UserRoleData;
use SAAS\Domain\Users\Models\User;

class AssignUserRoleAction
{
    public static function execute(UserRoleData $userRoleData, User $user): bool
    {
        try {
            $model = DB::transaction(function () use ($userRoleData, $user) {
                return $user->assignRole($userRoleData->role, $userRoleData->expires_at);
            });
        } catch (\Exception $e) {
            Log::error('Failed assigning user role.', [$e]);

            throw $e;
        }

        return $model;
    }
}
