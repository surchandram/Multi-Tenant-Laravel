<?php

namespace SAAS\Domain\Tenant\ViewModels\CustomerPortal\Auth;

use Illuminate\Support\Facades\Auth;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use SAAS\Domain\Users\DataTransferObjects\UserInvitationData;
use SAAS\Domain\Users\Models\User;
use SAAS\Domain\Users\Models\UserInvitation;

class GetCustomerInvitationViewModel extends ViewModel
{
    public function __construct(
        public readonly UserInvitation $userInvitation,
        public readonly Project $project,
        public ?User $user = null
    ) {
        $this->project->loadMissing([
            'owner',
        ]);

        if (Auth::check() && $project->owner->email != Auth::user()->email) {
            throw new \Exception('Please, sign out first before proceeding to customer portal.', 1);
        }

        if (! $this->user) {
            $this->user = User::firstWhere('email', $project->owner->email);
        }
    }

    public function invitation()
    {
        return UserInvitationData::fromModel($this->userInvitation);
    }

    public function isExistingUser()
    {
        return ! empty($this->user);
    }

    public function user()
    {
        if (! $this->user) {
            return UserData::fromPerson($this->project->owner);
        }

        return UserData::fromModel($this->user);
    }

    public function project()
    {
        return ProjectData::fromModel($this->project);
    }
}
