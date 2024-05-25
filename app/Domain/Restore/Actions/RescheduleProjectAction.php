<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;

class RescheduleProjectAction
{
    public static function execute(ProjectData $projectData, Project $project): Project
    {
        try {
            /* @var Project $project */
            DB::transaction(function () use ($projectData, &$project) {
                // update project
                $project->update([
                    'starts_at' => ($startsAt = $projectData->starts_at),
                    'ends_at' => \Illuminate\Support\Carbon::parse($startsAt)->addDays(
                        $project->starts_at->diffInDays($project->ends_at)
                    ),
                ]);

                return $project;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $project->refresh();
    }
}
