<?php

namespace SAAS\Http\Tenant\Controllers\Customers\Auth;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\SetProjectUserAction;
use SAAS\Domain\Restore\Invitations\CustomerInvitation;
use SAAS\Domain\Restore\Invitations\CustomerInvitationException;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Http\Auth\Requests\LoginRequest;

class AuthenticateCustomerSessionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request|\SAAS\Http\Auth\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request)
    {
        $invitation = null;

        try {
            // mark invitation as accepted
            if (filled($request->invitation)) {
                $invitation = CustomerInvitation::handleFromIdentifier($request->invitation, $request->email);
            }

            $redirect = $request->get('intended', $request->get('redirect', route('tenant.customers.portal.dashboard')));

            $request->authenticate();

            $request->session()->regenerate();

            // check if invitation is passed in current request
            // then set the user as project owner if the project user is null
            if ($invitation) {
                $project = Project::whereNull('user_id')->find($request->project);

                if ($project) {
                    $project = SetProjectUserAction::execute($project, $request->user());
                }
            }

            $path = $request->project ? route('tenant.customers.portal.projects.show', $request->project) : $redirect;

            return Inertia::location($path);
        } catch (CustomerInvitationException $e) {
            return back()->withErrors([
                'email' => $e->getMessage(),
            ]);
        }
    }
}
