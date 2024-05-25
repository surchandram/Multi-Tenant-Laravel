<?php

namespace SAAS\Http\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SAAS\App\Controllers\Controller;
use SAAS\App\Providers\RouteServiceProvider;
use SAAS\Domain\Users\Models\UserInvitation;

class InvitationAcceptExistingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Users\Models\UserInvitation  $userInvitation
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, UserInvitation $userInvitation)
    {
        $user = $request->user();
        $redirect = RouteServiceProvider::HOME;
        $message = __('Invitation processed successfully.');

        abort_if($userInvitation->email !== $user->email, Response::HTTP_FORBIDDEN);

        if ($userInvitation->role_id) {
            if (in_array($userInvitation->type, array_keys(config('saas.invitations.types')))) {
                $roleExpiresAt = $userInvitation->role_expires_at;

                switch ($userInvitation->type) {
                    case 'team':
                        $team = $userInvitation->roleable;
                        $class = config('laravel-roles.models.team');

                        if ($team instanceof $class) {
                            // team user setup
                            $team->users()->syncWithoutDetaching($user);

                            // resolve if shared role
                            $permitableId = ($team->is($userInvitation->role->roleable)) ? null : $team->id;

                            $user->assignRole($userInvitation->role, $roleExpiresAt, $permitableId);

                            $team->flushCache();
                            $user->flushCache();

                            $redirect = route('tenant.switch', $team);
                            $message = __(
                                'Steps required to join \':name\' team were completed successfully.', [
                                    'name' => $team->name,
                                ]);
                        }
                        break;

                    default:
                        if ($userInvitation->role->type === 'admin') {
                            $user->assignRole($userInvitation->role, $roleExpiresAt);
                        }
                        break;
                }
            }
        }

        $userInvitation->markAccepted();

        return redirect($redirect)->withSuccess($message);
    }
}
