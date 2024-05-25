<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__('Add Role | :name | Teams', ['name' => $team->name])) }}
    </x-slot>

    <section>
        <x-card class="mb-4">
            <x-slot name="header">
                <h5 class="text-lg font-semibold">{{ __('Add a Role') }}</h5>
            </x-slot><!-- /.card-header -->

            <div>
                <form method="POST" action="{{ route('teams.roles.store', $team) }}">
                    @csrf

                    <div class="mt-4">
                        <x-input-label for="name">{{ __('Name') }}</x-input-label>
                        <x-input class="w-full mt-1"
                            id="name"
                            type="text"
                            name="name"
                            placeholder="{{ __('Role name') }}"
                            value="{{ old('name') }}"
                            autofocus
                        />

                        <x-input-error :messages="$errors->get('name')" />
                    </div><!-- /.form-group -->

                    <div class="mt-4">
                        <x-input-label for="description">{{ __('Description') }}</x-input-label>
                        <x-textarea
                            class="w-full mt-1"
                            id="description"
                            name="description"
                            rows="3"
                            maxlength="255"
                            placeholder="{{ __('A short overview of what role entails') }}"
                            :value="old('description')" />

                        <x-input-error :messages="$errors->get('description')" />
                    </div><!-- /.form-group -->

                    <div class="mt-4">
                        <div class="inline-flex items-center gap-2">
                            <x-checkbox
                                name="usable"
                                class=""
                                id="usable"
                                value="1"
                                :checked="old('usable') == 1"
                            />
                            <x-input-label class="custom-control-label" for="usable">{{ __('Active') }}</x-input-label>
                        </div><!-- /.custom-control -->

                        <x-input-error :messages="$errors->get('usable')" />
                    </div><!-- /.form-group -->

                    <div class="mt-4">
                        @include('layouts.partials.forms._permissions', ['class' => get_class($team)])
                    </div><!-- /.form-group -->

                    <div class="mt-4">
                        <x-button rounded="md" light type="submit">
                            {{ __('Save') }}
                        </x-button>
                    </div><!-- /.form-group -->
                </form><!-- /form -->
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section>
</x-team-layout>
