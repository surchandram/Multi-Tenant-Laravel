<?php

namespace SAAS\Domain\Teams\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SAAS\Domain\Teams\DataTransferObjects\TeamData;
use SAAS\Domain\Teams\Models\Team;

class UpsertTeamAction
{
    public static function execute(TeamData $teamData, Model $owner): Team
    {
        try {
            $team = DB::transaction(function () use ($teamData, $owner) {
                $team = $owner->addOrUpdateTeam(
                    $teamData,
                    $teamData->id
                );

                return $team;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $team;
    }
}
