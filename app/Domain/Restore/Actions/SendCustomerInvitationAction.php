<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use SAAS\Domain\Restore\DataTransferObjects\ProjectStatusData;
use SAAS\Domain\Restore\Enums\ProjectStatuses;
use SAAS\Domain\Restore\Invitations\CustomerInvitation;
use SAAS\Domain\Restore\Models\Project;

class SendCustomerInvitationAction
{
    public static function execute(Project $project, $tenant): Project
    {
        try {
            $isNotApproved = $project->currentStatus->hasNoPriorityOver(ProjectStatuses::Approved);

            if (! $isNotApproved) {
                return abort(Response::HTTP_FORBIDDEN);
            }

            /* @var Project $project */
            DB::transaction(function () use (&$project, $tenant) {
                // update project 'status' to 'pending'
                $project->status_id = ProjectStatusData::fromEnum(ProjectStatuses::Pending)->id;
                $project->save();

                // fire job or event to send link to customer
                $invitation = new CustomerInvitation($project, $tenant);

                if (auth()->check()) {
                    $invitation->withReferable(auth()->user());
                }

                $invitation->send();

                return $project;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $project->refresh();
    }
}
