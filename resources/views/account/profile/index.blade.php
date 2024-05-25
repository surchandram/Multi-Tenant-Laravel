<x-account-layout>

    <x-slot name="pageTitle">
        {{ page_title(__('Profile | Account')) }}
    </x-slot>

    <x-card class="card">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold mb-2">{{ __('Profile') }}</h4>

            <p class="text-xs text-slate-400 font-semibold">
                {{ __('Make changes below to update your profile.') }}
            </p>
        </x-slot>

        <div class="card-body">
            <form method="POST" action="{{ route('account.profile.store') }}">
                @csrf

                <div class="flex flex-col md:grid md:grid-cols-3 md:gap-4">
                    <x-input-label for="first_name" class="md:col-span-1">{{ __('First name') }}</x-input-label>

                    <div class="md:col-span-2">
                        <x-input
                            id="first_name"
                            type="text"
                            class="w-full mt-2 md:mt-0"
                            name="first_name"
                            :value="old('first_name', auth()->user()->first_name)"
                            required
                            autofocus
                        />

                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                    <x-input-label for="last_name" class="md:col-span-1">{{ __('Last name') }}</x-input-label>

                    <div class="md:col-span-2">
                        <x-input
                            id="last_name"
                            type="text"
                            class="w-full mt-2 md:mt-0"
                            name="last_name"
                            :value="old('last_name', auth()->user()->last_name)"
                            required
                        />

                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                    <x-input-label for="username" class="md:col-span-1">{{ __('Username') }}</x-input-label>

                    <div class="md:col-span-2">
                        <x-input
                            id="username"
                            type="text"
                            class="w-full mt-2 md:mt-0"
                            name="username"
                            :value="old('username', auth()->user()->username)"
                            required
                        />

                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                    <x-input-label for="email" class="md:col-span-1">{{ __('E-Mail Address') }}</x-input-label>

                    <div class="md:col-span-2">
                        <x-input
                            id="email"
                            type="email"
                            class="w-full mt-2 md:mt-0"
                            name="email"
                            :value="old('email', auth()->user()->email)"
                            required
                        />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                    <x-input-label for="password" class="md:col-span-1">{{ __('Password') }}</x-input-label>

                    <div class="md:col-span-2">
                        <x-input
                            id="password"
                            type="password"
                            class="w-full mt-2 md:mt-0"
                            name="password"
                            required
                            autocomplete="current-password"
                        />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                    <div class="md:col-start-2 md:col-span-1">
                        <x-primary-button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </x-card>
</x-account-layout>
