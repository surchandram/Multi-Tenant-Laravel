<x-dashboard-layout>
    <x-slot name="pageTitle">{{ page_title(__('Create Team')) }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Team') }}
        </h2>
    </x-slot>

    <section>
        <x-card class="mb-4">
            <form
                x-data="{
                    changed(event) {
                        document.getElementById('name').value = window.domainNamer(event.target.value)
                        document.getElementById('domain').value = window.domainSlugger(event.target.value)
                    }
                }"
                method="POST" action="{{ route('teams.store') }}"
            >
                <x-validation-errors class="@if($errors->count())mb-2 @endif" />
                
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Team name')" />

                    <x-input
                        x-data=""
                        @input.debounce="changed"
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full mt-1"
                        required
                    />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="domain" :value="__('Domain')" />

                    <div class="w-full inline-flex items-center" class="mt-1">
                        <x-input
                            id="domain"
                            type="text"
                            name="domain"
                            placeholder="{{ __('domain...') }}"
                            value="{{ old('domain') }}"
                            class="flex-1 border-r-0 rounded-r-none ring-inset"
                            required
                        />

                        <div class="px-4 py-2 shadow-sm font-semibold bg-slate-200 border-[1px] !border-l-0 rounder-r-md">
                            {{ str_replace(['http://', 'https://'], '.', config('app.url')) }}
                        </div>
                    </div>

                    <x-input-error :messages="$errors->get('domain')" class="mt-2" />
                </div><!-- /.form-group -->

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />

                    <x-text-input
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                    />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-primary-button type="submit">{{ __('Create') }}</x-primary-button>
                </div>
            </form>
        </x-card><!-- /.card -->
    </section><!-- /.row -->
</x-dashboard-layout>
