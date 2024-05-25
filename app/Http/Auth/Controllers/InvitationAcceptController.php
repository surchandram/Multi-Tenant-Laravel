<?php

namespace SAAS\Http\Auth\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Users\Models\UserInvitation;

class InvitationAcceptController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, UserInvitation $userInvitation)
    {
        $data = $userInvitation->only('id', 'identifier', 'type');

        [0 => $firstName, 1 => $lastName] = array_pad(explode(' ', $userInvitation->name), 2, null);

        $request->session()->put('invitation_data', $data);

        $request->session()->put(
            'form',
            array_merge(['first_name' => $firstName, 'last_name' => $lastName], $userInvitation->only('name', 'email'))
        );

        return redirect()->route('register', $data);
    }
}
