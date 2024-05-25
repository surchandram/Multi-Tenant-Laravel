<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\Notification;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Restore\Enums\ProjectStatuses;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Notifications\Customer\ProjectApprovedNotification;
use SAAS\Domain\Restore\Notifications\Project\Approved\TeamNotification;

class SendProjectApprovedNotificationsAction
{
    public static function execute(Project $project, Company $company)
    {
        $allowed = $project->currentStatus->is(ProjectStatuses::Approved);

        if (! $allowed) {
            return;
        }

        $project->loadMissing([
            'owner',
            'user',
            'team.users',
        ]);

        // send mail to 'customer'
        if (! filled($project->user)) {
            $project->owner->notify(new ProjectApprovedNotification($project, $company));
        } else {
            $project->user->notify(new ProjectApprovedNotification($project, $company));
        }

        // notify assigned 'team' on project schedule
        $users = $project->team->users;

        Notification::send($users, new TeamNotification($project, $company));
    }
}
