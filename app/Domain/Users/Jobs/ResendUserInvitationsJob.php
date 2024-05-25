<?php

namespace SAAS\Domain\Users\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SAAS\Domain\Users\Events\SendUserInvitation;
use SAAS\Domain\Users\Models\UserInvitation;

class ResendUserInvitationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        UserInvitation::isStillValid()->each(function ($invitation) {
            event(new SendUserInvitation($invitation));
        });
    }
}
