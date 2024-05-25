<?php

namespace SAAS\Domain\Restore\Invitations;

use Miracuthbert\Multitenancy\Models\Tenant;
use SAAS\App\UserInvitations\InvitationAbstract;
use SAAS\Domain\Companies\DataTransferObjects\CompanyData;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Users\Models\User;
use SAAS\Domain\Users\Models\UserInvitation;

class CustomerInvitation extends InvitationAbstract
{
    public function __construct(
        public readonly Project $project,
        public readonly Tenant $tenant,
    ) {
        $this->project->loadMissing([
            'owner',
            'address.country',
        ]);

        $expiresAt = $this->project->ends_at ?? now();

        $this->setFillable([
            'name' => $this->project->owner->name,
            'email' => $this->project->owner->email,
            'expires_at' => $expiresAt->copy()?->addDays(
                config('saas.invitations.expiry.'.CustomerInvitation::class, 15)
            ),
        ]);

        $this->withData('mail', [
            'project' => ProjectData::fromModel($project),
            'company' => CompanyData::fromModel($tenant),
        ]);
    }

    public static function handleFromIdentifier(string $identifier, string $email)
    {
        $userInvitation = UserInvitation::isStillValid()
            ->whereIdentifier($identifier)
            ->whereEmail($email)
            ->whereType(static::class)
            ->first();

        if (! $userInvitation) {
            throw CustomerInvitationException::isInvalid();
        }

        $user = User::whereEmail($email)->first();

        if (! $user) {
            throw CustomerInvitationException::emailIsInvalid();
        }

        $done = (new CustomerInvitationHandler(
            $user,
            $userInvitation
        ))->handle();

        if ($done) {
            return $userInvitation->fresh();
        }

        return null;
    }
}
