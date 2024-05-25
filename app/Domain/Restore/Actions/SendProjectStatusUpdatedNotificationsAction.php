<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\Notification;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Notifications\ProjectStatusUpdatedNotification;

class SendProjectStatusUpdatedNotificationsAction
{
    public static function execute(Project $project, Company $company)
    {
        // notify project owner
        Notification::send([
            $project->owner,
        ], new ProjectStatusUpdatedNotification($project, $company, true));

        // notify assigned 'team' on project
        if (filled(($team = $project->team))) {
            $users = $team->users;

            if ($users->count() > 0) {
                Notification::send($users, new ProjectStatusUpdatedNotification($project, $company));
            }
        }

        return true;
    }
}
