<?php

namespace SAAS\Domain\Users\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Users\DataTransferObjects\RoleData;
use SAAS\Domain\Users\Models\Role;

class UpsertRoleAction
{
    public static function execute(RoleData $roleData, Role $role = null): Role
    {
        try {
            $model = DB::transaction(function () use ($roleData, $role) {
                $data = [
                    'name' => $roleData->name,
                    'slug' => $roleData->parent?->id == $role?->parent?->id ? $role->slug : null,
                    'type' => $roleData->type,
                    'parent_id' => $roleData->parent?->id ?? null,
                    'description' => $roleData->description,
                    'usable' => $roleData->usable,
                ];

                if ($role) {
                    $role->update($data);

                    // sync permissions
                    $role->syncPermissions($roleData->permissions->toCollection()->pluck('id')->toArray());

                    return $role->refresh();
                } else {
                    $record = Role::withTrashed()->updateOrCreate([
                        'name' => $roleData->name,
                    ], $data);

                    if ($record->trashed()) {
                        $record->restore();
                    }

                    // sync permissions
                    $record->syncPermissions($roleData->permissions->toCollection()->pluck('id')->toArray());

                    return $record->refresh();
                }
            });
        } catch (\Exception $e) {
            Log::error('Failed upserting role.', [$e]);

            throw $e;
        }

        return $model;
    }
}
