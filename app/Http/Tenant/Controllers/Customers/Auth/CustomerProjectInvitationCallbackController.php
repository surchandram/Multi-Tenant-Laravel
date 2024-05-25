<?php

namespace SAAS\Http\Tenant\Controllers\Customers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Miracuthbert\Multitenancy\Models\Tenant;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\DataTransferObjects\ProjectData;
use SAAS\Domain\Restore\Invitations\CustomerInvitationException;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Tenant\ViewModels\CustomerPortal\Auth\GetCustomerInvitationViewModel;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use SAAS\Domain\Users\Models\User;
use SAAS\Domain\Users\Models\UserInvitation;

class CustomerProjectInvitationCallbackController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request, Tenant $tenant, UserInvitation $userInvitation, Project $project)
    {
        if ($userInvitation->hasExpired()) {
            throw CustomerInvitationException::isInvalid();
        }

        // first validate project param matches one in invitation
        $projectData = ProjectData::fromId($userInvitation->data['mail']['project']['id']);

        if ($project->id != $projectData->id) {
            abort(Response::HTTP_NOT_FOUND);
        }

        // find if a user with 'email' matching 'invitation email' exists
        $userData = transform(
            User::whereEmail($userInvitation->email)->first(),
            fn ($user) => ! $user ? null : UserData::fromModel($user)
        );

        // if user exists but does not match project's property owner email
        // then throw exception
        if ($userData) {
            if ($userData->email !== $project->owner->email) {
                throw new \Exception('You cannot create an account with an email that does not match project owner\'s.');
            }
        }

        return redirect()->route('tenant.customers.portal.auth.invitation.project.auth-form', [
            $userInvitation->identifier,
            $project->id,
        ]);
    }

    /**
     * Show the login/registration form.
     *
     * @return \Inertia\Response
     */
    public function show(Tenant $tenant, UserInvitation $userInvitation, Project $project)
    {
        $model = new GetCustomerInvitationViewModel($userInvitation, $project);

        return Inertia::render('tenant/views/customers/portal/auth/Invitation', compact('model'));
    }
}
