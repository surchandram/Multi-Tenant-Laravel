<?php

namespace SAAS\Domain\Restore\Actions;

use SAAS\Domain\Restore\Models\MoistureMap;
use SAAS\Domain\Restore\Models\Project;

class DestroyProjectMoistureMapAction
{
    public static function execute(Project $project, MoistureMap $moistureMap): Project
    {
        try {
            $project->moistureMap()->where('id', $moistureMap->id)->delete();
        } catch (\Exception $e) {
            throw $e;
        }

        return $project;
    }
}
