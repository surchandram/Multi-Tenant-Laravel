<?php

namespace SAAS\Domain\Teams\Traits;

use SAAS\Domain\Teams\DataTransferObjects\TeamData;
use SAAS\Domain\Teams\Models\Team;

trait CanOwnTeam
{
    /**
     * Boot `CanOwnTeam` trait.
     */
    public static function bootCanOwnTeam()
    {
        //
    }

    /**
     * Determine if model has any teams.
     *
     * @return bool
     */
    public function hasTeams()
    {
        return $this->teams->count();
    }

    /**
     * Create a new team for entity.
     *
     * @param  \SAAS\Domain\Teams\DataTransferObjects\TeamData  $teamData The details of the team
     * @return bool|\SAAS\Domain\Teams\Models\Team
     */
    public function addTeam(TeamData $teamData)
    {
        $team = new Team($teamData->only(
            'name',
            'description',
            'usable',
        )->toArray());

        return $this->teams()->save($team);
    }

    /**
     * Create or update team for entity.
     *
     * @param  \SAAS\Domain\Teams\DataTransferObjects\TeamData  $teamData The details of the team
     * @param  int|null  $id The existing teams team
     * @return \SAAS\Domain\Teams\Models\Team
     */
    public function addOrUpdateTeam(TeamData $teamData, $id = null)
    {
        $team = $this->teams()->updateOrCreate([
            'id' => $id,
        ], $teamData->only(
            'name',
            'description',
            'usable',
        )->toArray());

        return $team;
    }

    /**
     * Get all of the model's teams.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function teams()
    {
        return $this->morphMany(Team::class, 'teamable');
    }
}
