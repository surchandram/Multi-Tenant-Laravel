@props([
	'route',
	'countries',
	'title' => __('Add new address'),
	'details' => __('Fill in the details below to link an address to your account.')
])

<x-card class="card">
    <x-slot name="header" class="border-b">
        <h4 class="text-lg font-semibold mb-2">{{ $title }}</h4>

        <p class="text-xs text-slate-400 font-semibold">
            {{ $details }}
        </p>
    </x-slot>

    <div class="card-body">
        <form method="POST" action="{{ $route }}">
            @csrf

            <div>
                <x-input-label for="name">{{ __('Full name') }}</x-input-label>

                <x-input
                    id="name"
                    type="text"
                    class="w-full mt-2"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="address_1">{{ __('Address line 1') }}</x-input-label>

                <x-input
                    id="address_1"
                    type="text"
                    class="w-full mt-2"
                    name="address_1"
                    :value="old('address_1')"
                    required
                />

                <x-input-error :messages="$errors->get('address_1')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="address_2">{{ __('Address line 2') }}</x-input-label>

                <x-input
                    id="address_2"
                    type="text"
                    class="w-full mt-2"
                    name="address_2"
                    :value="old('address_2')"
                />

                <x-input-error :messages="$errors->get('address_2')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="state">{{ __('State') }}</x-input-label>

                <x-input
                    id="state"
                    type="text"
                    class="w-full mt-2"
                    name="state"
                    :value="old('state')"
                />

                <x-input-error :messages="$errors->get('state')" class="mt-2" />
            </div>

            <!-- City / Postal code -->
            <div class="flex flex-col mt-4 md:grid md:grid-cols-2 md:gap-4">
                <!-- City -->
                <div class="">
                    <x-input-label for="city">{{ __('City') }}</x-input-label>

                    <x-input
                        id="city"
                        type="text"
                        class="w-full mt-2"
                        name="city"
                        :value="old('city')"
                        required
                    />

                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                </div>

                <!-- Postal code -->
                <div class="mt-2 md:mt-0">
                    <x-input-label for="postal_code">{{ __('Postal code') }}</x-input-label>

                    <x-input
                        id="postal_code"
                        type="text"
                        class="w-full mt-2"
                        name="postal_code"
                        :value="old('postal_code')"
                        required
                    />

                    <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                </div>
            </div>

            <div class=" mt-4">
                <x-input-label for="country_id">{{ __('Country') }}</x-input-label>

                <x-select
                    id="country_id"
                    class="w-full mt-2"
                    name="country_id"
                    required
                >
                    <option value="">{{ __('Choose country') }}</option>
                    @foreach ($countries as $country)
                        <option
                            {{ old('country_id') == $country->id ? ' selected ' : '' }}
                            value="{{ $country->id }}"
                        >
                            {{ $country->name }}
                        </option>
                    @endforeach
                </x-select>


                <x-input-error :messages="$errors->get('country_id')" class="mt-2" />
                    {{ old('country_id') }}
            </div>

            <div class="w-full flex items-center gap-2 mt-4">
                <x-checkbox
                    :checked="old('default', false)"
                    id="default"
                    name="default"
                    value="1"
                />

                <x-input-label for="default">{{ __('Set as default')}}</x-input-label>
            </div>


            <div class="w-full flex items-center gap-2 mt-4">
                <x-checkbox
                    :checked="old('billing', false)"
                    id="billing"
                    name="billing"
                    value="1"
                />

                <x-input-label for="billing">{{ __('Use for Billing')}}</x-input-label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button type="submit">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-card>
