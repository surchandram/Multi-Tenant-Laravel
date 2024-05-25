<?php

namespace SAAS\Domain\Teams\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Teams\DataTransferObjects\TeamData;
use SAAS\Domain\Teams\Models\Team;

class UpdateTeamAction
{
    public static function execute(TeamData $teamData, Team $team): Team
    {
        try {
            $team = DB::transaction(function () use ($teamData, $team) {
                $team->update($teamData->only(
                    'name',
                    'description',
                    'usable',
                )->toArray());

                return $team->fresh();
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $team;
    }
}
