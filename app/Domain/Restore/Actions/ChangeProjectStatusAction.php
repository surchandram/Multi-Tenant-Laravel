<?php

namespace SAAS\Domain\Restore\Actions;

use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Enums\ProjectStatuses;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectStatus;

class ChangeProjectStatusAction
{
    /**
     * Change project status.
     *
     * @param  int|\SAAS\Domain\Restore\Models\Project|\SAAS\Domain\Restore\DataTransferObjects\ProjectData  $projectData
     */
    public static function execute($projectData, Company $company, string $status): Project
    {
        $project = self::resolveProject($projectData);

        $status = ProjectStatus::whereSlug($status)->first();

        if (filled($status)) {
            $project->status()->associate($status);
            $project->save();

            $originalProject = new Project(
                collect($project->getOriginal())
                    ->toArray()
            );

            // send notification if status was changed
            if (($originalProject->status() !== $project->status()) && $project->current_status->hasPriorityOver(ProjectStatuses::Pending)) {
                SendProjectStatusUpdatedNotificationsAction::execute($project->fresh([
                    'status',
                    'address.country',
                ]), $company);
            }
        }

        return $project;
    }

    protected static function resolveProject($projectData): Project
    {
        if ($projectData instanceof Project) {
            return $projectData;
        }

        if ($projectData instanceof ProjectData) {
            return Project::findOrFail($projectData->id);
        }

        if (is_numeric($projectData)) {
            return Project::findOrFail($projectData);
        }

        throw new \Exception("Unsupported type for [$projectData] when resolving for [\SAAS\Domain\Restore\Models\Project]");
    }
}
