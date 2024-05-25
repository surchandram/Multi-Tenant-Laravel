<?php

namespace SAAS\Domain\Users\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Users\DataTransferObjects\PermissionData;
use SAAS\Domain\Users\Models\Permission;

class UpsertPermissionAction
{
    public static function execute(PermissionData $permissionData, Permission $permission = null): Permission
    {
        try {
            $model = DB::transaction(function () use ($permissionData, $permission) {
                $data = [
                    'name' => $permissionData->name,
                    'type' => $permissionData->type,
                    'description' => $permissionData->description,
                    'usable' => $permissionData->usable,
                ];

                if ($permission) {
                    $permission->update($data);

                    return $permission->refresh();
                } else {
                    $record = Permission::withTrashed()->updateOrCreate([
                        'name' => $permissionData->name,
                    ], $data);

                    if ($record->trashed()) {
                        $record->restore();
                    }

                    return $record;
                }
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $model;
    }
}
