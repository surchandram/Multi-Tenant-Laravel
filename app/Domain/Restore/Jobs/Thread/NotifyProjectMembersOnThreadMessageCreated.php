<?php

namespace SAAS\Domain\Restore\Jobs\Thread;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use SAAS\App\Support\Roles;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Restore\Notifications\Project\NoteCreatedNotification;
use SAAS\Domain\Threads\Models\Message;

class NotifyProjectMembersOnThreadMessageCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public readonly array $project,
        public readonly Message $message,
        public readonly Collection $users,
        public readonly Company $company,
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = $this->message->load('user')->toArray();

        $project = $this->project;

        // get company admins
        $users = $this->company->users()->whereRoleIs(Roles::$roleWhenCreatingCompany)->get();

        Notification::send(
            $users = $users->merge($this->users)->unique('id'),
            new NoteCreatedNotification(
                $project,
                $message,
                $this->company->withoutRelations()
            )
        );

        info('notified users', [$users->toArray()]);
    }
}
