<?php

namespace SAAS\Http\Auth\Controllers;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialUser;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use SAAS\App\Controllers\Controller;
use SAAS\App\Providers\RouteServiceProvider;
use SAAS\Domain\Auth\Actions\RegisterUserAction;
use SAAS\Domain\Auth\DataTransferObjects\RegisteredUserData;
use SAAS\Domain\SocialAccount\Actions\UpsertSocialAccountAction;
use SAAS\Domain\SocialAccount\DataTransferObjects\SocialAccountData;
use SAAS\Domain\SocialAccount\Models\SocialAccount;
use SAAS\Domain\Users\Models\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialiteController extends Controller
{
    /**
     * Redirect to Socialite provider for login.
     *
     * @param string $provider
     * @return RedirectResponse
     */
    public function redirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle Socialite callback to application.
     *
     * @param Request $request
     * @param string $provider
     * @return Application|\Illuminate\Http\RedirectResponse|Redirector
     * @throws Exception
     */
    public function callback(Request $request, string $provider): Redirector|\Illuminate\Http\RedirectResponse|Application
    {
        $capitalized = Str::ucfirst($provider);

        try {
            $oAuthUser = Socialite::driver($provider)->user();
        } catch (InvalidStateException) {
            $oAuthUser = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException | Exception $exception) {
            if ($request->has('error') && $request->query('error') == 'user_cancelled_login') {
                Session::flash('status', "You cancelled you login request via $capitalized.");
            } else {
                if (!app()->environment('production')) {
                    throw $exception;
                }

                Log::error($exception->getMessage(), [$exception->getTraceAsString()]);
                Session::flash('error', "An error occurred when logging you in via $capitalized. Kindly try again or contact support if the issue persists.");
            }

            return redirect()->route('login');
        }

        /** @var SocialAccount $account */
        $account = SocialAccount::query()->where([
            'provider' => $provider,
            'provider_user_id' => $oAuthUser->getId(),
        ])->first();

        $user = User::query()->where('email', $oAuthUser->getEmail())
            ->when($account, function (Builder $query, $account) {
                $query->orWhere('id', $account->user_id);
            })->first();

        if (is_null($user)) {
            $user = $this->createUser($oAuthUser, $provider);
        }

        Auth::login($user->refresh(), true);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * @param SocialUser $oAuthUser
     * @param string $provider
     * @return User
     * @throws Exception
     */
    private function createUser(SocialUser $oAuthUser, string $provider): User
    {
        $user = RegisterUserAction::execute(RegisteredUserData::fromSocialAuth($oAuthUser));
        UpsertSocialAccountAction::execute(SocialAccountData::fromSocialAuth($oAuthUser, $provider), $user);

        event(new Registered($user));
        return $user->refresh();
    }
}
