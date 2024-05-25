<x-account-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('Two Factor Authentication | Account')) }}
    </x-slot>

    @if (auth()->user()->twoFactorPendingVerification())
        @include('account.twofactor.partials._verification_form')
    @elseif(auth()->user()->twoFactorEnabled())
        @include('account.twofactor.partials._delete_form')
    @else
        <x-card class="mb-4">
            <x-slot name="header">
                <h4 class="text-lg font-semibold">{{ __('Two Factor Authentication') }}</h4>
            </x-slot><!-- /.card-header -->

            <div class="card-body">
                <form method="POST" action="{{ route('account.twofactor.store') }}">
                    @csrf

                    <div class="flex flex-col md:grid md:grid-cols-3 md:gap-4">
                        <x-input-label for="dial_code" class="md:col-span-1">{{ __('Dial Code') }}
                        </x-input-label>

                        <div class="md:col-span-2 mt-2 md:mt-0">
                            <x-select
                                id="dial_code"
                                class="w-full select2"
                                name="dial_code"
                                required
                            >
                                <option value="">---</option>
                                @foreach ($countries as $country)
                                    <option
                                        value="{{ $country->dial_code }}"
                                        {{ old('dial_code') == $country->dial_code ? 'selected' : '' }}
                                    >
                                        {{ $country->name }} (+{{ $country->dial_code }})
                                    </option>
                                @endforeach
                            </x-select>

                            <x-input-error :messages="$errors->get('dial_code')" class="mt-2" />
                        </div>
                    </div><!-- /.form-group -->

                    <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                        <x-input-label for="phone_number" class="md:col-span-1">{{ __('Phone Number') }}
                        </x-input-label>

                        <div class="md:col-span-2 mt-2 md:mt-0">
                            <x-input
                                id="phone_number"
                                type="text"
                                class="w-full"
                                name="phone_number"
                                value="{{ old('phone_number') }}"
                                required
                                autocomplete="phone_number"
                            />

                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                        </div>
                    </div><!-- /.form-group -->

                    <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                        <x-input-label for="current_password" class="md:col-span-1">{{ __('Password') }}
                        </x-input-label>

                        <div class="md:col-span-2 mt-2 md:mt-0">
                            <x-input
                                id="current_password"
                                type="password"
                                class="w-full"
                                name="current_password"
                                required
                                autocomplete="current-password"
                            />

                            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                        </div>
                    </div><!-- /.form-group -->

                    <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                        <div class="md:col-start-2 md:col-span-1">
                            <x-primary-button type="submit" class="">
                                {{ __('Enable') }}
                            </x-primary-button>
                        </div>
                    </div><!-- /.form-group -->
                </form>
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    @endif
</x-account-layout>
