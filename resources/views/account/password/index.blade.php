<x-account-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('Change Password | Account')) }}
    </x-slot>

    <x-card>
        <x-slot name="header">
            <h4 class="text-lg font-semibold mb-2">{{ __('Change Password') }}</h4>

            <p class="text-xs text-slate-400 font-semibold">
                {{  __('Use form below to update your password and keep your account secure')  }}
            </p>
        </x-slot>

        <div class="card-body">
            <form method="POST" action="{{ route('account.password.store') }}">
                @csrf

                <div class="flex flex-col md:grid md:grid-cols-3 md:gap-4">
                    <x-input-label for="current_password" class="md:col-span-1">{{ __('Current Password') }}
                    </x-input-label>

                    <div class="md:col-span-2">
                        <x-input
                            id="current_password"
                            type="password"
                            class="w-full mt-2 md:mt-0"
                            name="current_password"
                            required
                            autofocus
                        />

                        <x-input-error :messages="$errors->get('current_password')" />
                    </div>
                </div>

                <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                    <x-input-label for="password" class="md:col-span-1">{{ __('New Password') }}</x-input-label>

                    <div class="md:col-span-2">
                        <x-input
                            id="password"
                            type="password"
                            class="w-full mt-2 md:mt-0"
                            name="password"
                            required
                        />

                        <x-input-error :messages="$errors->get('password')" />
                    </div>
                </div>


                <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                    <x-input-label for="password-confirm" class="md:col-span-1">{{ __('Confirm Password') }}
                    </x-input-label>

                    <div class="md:col-span-2">
                        <x-input
                            id="password-confirm"
                            type="password"
                            class="w-full mt-2 md:mt-0"
                            name="password_confirmation"
                            required
                        />
                    </div>
                </div>

                <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                    <div class="md:col-start-2 md:col-span-1">
                        <x-primary-button type="submit" class="btn btn-primary">
                            {{ __('Change Password') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </x-card>
</x-account-layout>
