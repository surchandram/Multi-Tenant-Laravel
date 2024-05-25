<?php

namespace SAAS\Domain\Teams\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SAAS\Domain\Teams\Models\Team;

class TeamCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Team instance.
     *
     * @var \SAAS\Domain\Teams\Models\Team
     */
    public $team;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }
}
