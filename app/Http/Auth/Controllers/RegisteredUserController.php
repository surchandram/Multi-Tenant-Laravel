<?php

namespace SAAS\Http\Auth\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\App\Providers\RouteServiceProvider;
use SAAS\App\UserInvitations\Traits\HandleInvitationTrait;
use SAAS\Domain\Users\Models\User;

class RegisteredUserController extends Controller
{
    use HandleInvitationTrait;

    public $redirectTo = RouteServiceProvider::HOME;

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return Inertia::render('auth/views/Register', [
            'form' => $request->session()->pull('form', []),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:15'],
            'last_name' => ['required', 'string', 'max:15'],
            'username' => ['required', 'string', 'max:15', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required'],
        ]);

        $user = null;

        try {
            DB::transaction(function () use (&$user, $request) {
                // create user
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                ]);

                // handle invitation if present
                if ($request->session()->has('invitation_data')) {
                    $handler = $this->handleInvitationFromSession($user, $request);

                    if ($handler) {
                        if (($redirectTo = $handler->redirectTo())) {
                            $this->redirectTo = $redirectTo;
                        }
                    }
                }
            });

            event(new Registered($user));

            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return back()->withInput()->withErrors([
                'general' => $e->getMessage(),
            ])->withError(__('auth.registration_failed'));
        }
    }
}
