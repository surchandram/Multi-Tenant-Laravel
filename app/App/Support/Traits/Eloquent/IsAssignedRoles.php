<?php

namespace SAAS\App\Support\Traits\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait IsAssignedRoles
{
    /**
     * Boot `IsAssignedRoles` trait.
     */
    public static function bootIsAssignedRoles()
    {
        //
    }

    /**
     * Revoke given role now or at the given time.
     *
     * @param  \Miracuthbert\LaravelRoles\Models\Role  $role
     * @param  \Illuminate\Database\Eloquent\Model  $giver
     * @param  \Carbon\Carbon|string|null  $expiresAt
     * @return bool
     */
    public function revokeRoleByGiver($role, $giver, $expiresAt = null)
    {
        $expiresAt = isset($expiresAt) ?
            Carbon::parse($expiresAt)->toDateTimeString() :
            Carbon::now();

        $id = $this->parseRoleId($role);

        // set expiry
        $expiry = $expiresAt;

        $giverId = $giver instanceof Model ? $giver->id : $giver;

        $updated = $this->roles()
            ->where('permitable_id', $giverId)
            ->whereNull('expires_at')
            ->orWhere('expires_at', '>', Carbon::now())
            ->updateExistingPivot($id, [
                'expires_at' => $expiry,
            ]);

        // check if updated
        if (! $updated) {
            return false;
        }

        $this->flushUserRolesCache();

        return true;
    }
}
