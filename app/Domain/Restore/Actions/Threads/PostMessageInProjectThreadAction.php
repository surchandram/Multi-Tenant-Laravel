<?php

namespace SAAS\Domain\Restore\Actions\Threads;

use Illuminate\Support\Facades\Log;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Jobs\Thread\NotifyProjectMembersOnThreadMessageCreated;
use SAAS\Domain\Threads\Models\Message;

class PostMessageInProjectThreadAction
{
    public static function execute(Message $message, Company $company): Message
    {
        try {
            $users = $message->thread->threadable->team?->users ?? collect();
            $project = $message->thread->threadable->load('address');

            dispatch(new NotifyProjectMembersOnThreadMessageCreated(
                ProjectData::fromModel($project)->toArray(),
                $message->withoutRelations(),
                $users,
                $company,
            ));
        } catch (\Exception $exception) {
            Log::error('Failed notifying thread users.', [$exception]);

            throw $exception;
        }

        return $message;
    }
}
