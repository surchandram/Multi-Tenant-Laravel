@extends('layouts.plain')

@section('title', page_title(__('Create Team')))

@section('content')
    <section class="w-full md:max-w-7xl grid grid-cols-5">
        <div class="col-span-4 md:col-span-5 mx-auto mb-4">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-medium text-lg text-black dark:text-white">
                    {{ __('Create new team') }}
                </h3>

                <x-link-button themed themed is-text rounded="md" href="{{ route('dashboard') }}">
                    {{ __('Cancel') }}
                </x-link-button>
            </div>

            <form
                x-data="{
                    picking: false,
                    apps: [],
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

                        <div class="px-4 py-3 shadow-sm font-semibold bg-blue-200 border-[1px] !border-l-1 rounded-r-md">
                            {{ str_replace(['http://', 'https://'], '.', config('app.url')) }}
                        </div>
                    </div>

                    <x-input-error :messages="$errors->get('domain')" class="mt-2" />
                </div><!-- /.form-group -->

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />

                    <x-input
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                    />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div><!-- /.form-group -->

                <!-- Logo -->
                <div class="mt-4">
                    <x-input-label for="logo" :value="__('Team Logo')" />

                    <x-file-input
                        id="logo"
                        class="block mt-1 w-full"
                        name="logo"
                        :value="old('logo')"
                        required
                    />

                    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                </div><!-- /.form-group -->

                <!-- Apps -->
                <div x-data="{ showing: '' }" class="mt-4">
                    <x-input-label :value="__('Pick Apps')" />

                    <div x-show="picking" style="display: none;" class="max-w-sm flex flex-col gap-6">
                        <div class="mt-2 mb-2">
                            <x-button type="button" is-text @click.prevent="picking = false">
                                <i class="bi bi-chevron-left mr-2"></i>
                                {{ __('Done') }}&nbsp;
                                (<span x-text="apps.length"></span>)
                            </x-button>
                        </div>

                        @foreach($webApps as $webApp)
                            <label for="{{ $webApp->id }}" class="w-full flex items-center gap-2">
                                <x-checkbox x-model="apps" id="{{ $webApp->id }}" :value="$webApp->id" />
                                <div class="flex-1">
                                    <x-card>
                                        <h4 class="text-sm font-semibold">{{ $webApp->name }}</h4>

                                        {{-- App Description --}}
                                        <p
                                            class="mt-3"
                                            x-show="showing == @js($webApp->id)"
                                            @click="showing = ''"
                                        >
                                            {{ $webApp->description }}
                                        </p>

                                        {{-- Description Toggler --}}
                                        <p class="mt-3">
                                            <a
                                                href="#"
                                                class="hover:underline"
                                                x-show="showing != @js($webApp->id)"
                                                @click.prevent="showing = @js($webApp->id)"
                                            >
                                                {{ __('Short overview...') }}
                                            </a>
                                            <a
                                                href="#"
                                                class="hover:underline"
                                                x-show="showing == @js($webApp->id)"
                                                @click.prevent="showing = ''"
                                            >
                                                {{ __('Hide') }} <i class="bi bi-chevron-up"></i>
                                            </a>
                                        </p>
                                    </x-card>
                                </div>
                            </label>
                        @endforeach

                        <div class="mt-2 mb-2">
                            <x-button type="button" is-text @click.prevent="picking = false">
                                <i class="bi bi-chevron-left mr-2"></i>
                                {{ __('Done') }}&nbsp;
                                (<span x-text="apps.length"></span>)
                            </x-button>
                        </div>
                    </div>

                    <div x-show="!picking" class="mt-2">
                        <x-button
                            type="button"
                            outlined
                            themed
                            size="lg"
                            class="w-full hover:underline"
                            @click.prevent="picking = !picking"
                        >
                            (<span x-text="apps.length"></span>) {{ __('Pick an App') }}
                        </x-button>
                    </div>

                    <x-input-error :messages="$errors->get('apps')" class="mt-2" />
                </div><!-- /.form-group -->

                <div class="mt-4 flex items-center justify-end">
                    <x-button size="lg" type="submit">{{ __('Create') }}</x-button>
                </div>
            </form>
        </div><!-- /.card -->
    </section><!-- /.row -->
@endsection
