<?php

namespace SAAS\Http\Tenant\Controllers\Customers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\SetProjectUserAction;
use SAAS\Domain\Restore\Invitations\CustomerInvitation;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Http\Auth\Requests\RegistrationRequest;

class RegisterCustomerStoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegistrationRequest $request)
    {
        try {
            $user = $request->registerUser();

            // mark invitation as accepted
            // then set the project's user
            if (filled($request->invitation)) {
                CustomerInvitation::handleFromIdentifier($request->invitation, $request->email);

                $project = Project::find($request->project);

                $project = SetProjectUserAction::execute($project, $user);
            }

            Auth::login($user);

            return redirect()->route(
                'tenant.customers.portal.projects.show',
                $project
            )->withSuccess(
                __('customer.auth.signup.successful')
            )->withInfo(
                __('auth.email_verification_notice')
            )->withInfoAction([
                'action' => route('verification.send'),
                'name' => __('auth.resend_verification_email'),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed registering user from customer portal', [$e]);

            return back()->withErrors([
                'general' => $e->getMessage(),
            ])->withError(__('auth.registration_failed'));
        }
    }
}
