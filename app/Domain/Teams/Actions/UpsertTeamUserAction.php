<?php

namespace SAAS\Domain\Teams\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Teams\Models\Team;

class UpsertTeamUserAction
{
    public static function execute(Team $team, int $userId): bool
    {
        try {
            return DB::transaction(function () use ($team, $userId) {
                $team->users()->syncWithoutDetaching([$userId]);

                return true;
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
