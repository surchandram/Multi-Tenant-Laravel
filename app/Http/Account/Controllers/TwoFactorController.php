<?php

namespace SAAS\Http\Account\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\App\TwoFactor\TwoFactor;
use SAAS\Domain\Account\ViewModels\TwoFactorSetupViewModel;
use SAAS\Http\TwoFactor\Requests\TwoFactorStoreRequest;
use SAAS\Http\TwoFactor\Requests\TwoFactorVerifyRequest;

class TwoFactorController extends Controller
{
    /**
     * TwoFactorController constructor.
     *
     * @return void
     **/
    public function __construct(Request $request)
    {
        $this->middleware(['password.confirm'])->only('index', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Request $request)
    {
        $model = new TwoFactorSetupViewModel();

        return inertia('account/views/security/TwoFactor', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TwoFactorStoreRequest $request, TwoFactor $twoFactor)
    {
        $user = $request->user();

        $user->twoFactor()->create([
            'phone' => $request->phone_number,
            'dial_code' => $request->dial_code,
        ]);

        if ($response = $twoFactor->register($user)) {
            $user->twoFactor()->update([
                'identifier' => $response->user->id,
            ]);
        }

        return back()->withSuccess(__('Please enter the verification code sent to you.'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(TwoFactorVerifyRequest $request)
    {
        $request->user()->twoFactor()->update([
            'verified_at' => now(),
        ]);

        return back()->withSuccess(__('Your account is now secured with two factor authentication.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TwoFactor $twoFactor)
    {
        $user = $request->user();

        if ($twoFactor->delete($user)) {
            $user->twoFactor()->delete();

            return back()->withSuccess(__('Two factor authentication is now disabled for your account.'));
        }

        return back();
    }
}
