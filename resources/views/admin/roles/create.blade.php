@extends('admin.layouts.default')

@section('title', page_title(__('Add Role')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider">{{ __('Add new role') }}</h4>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf

                <div class="mt-4">
                    <x-input-label for="name">{{ __('Name') }}</x-input-label>

                    <x-input
                        class="w-full mt-2"
                        id="name"
                        type="text"
                        name="name"
                        placeholder="Role name"
                        value="{{ old('name') }}"
                        autofocus
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div><!-- /.form-group -->

                @include('admin.layouts.partials.forms._permitables')

                <div class="mt-4">
                    @include('admin.roles.partials.forms._parent_roles')
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="description">{{ __('Description') }}</x-input-label>

                    <x-textarea
                        class="w-full mt-2"
                        id="description"
                        name="description"
                        rows="3"
                        maxlength="255"
                        placeholder="A short overview of what role entails"
                        :value="old('description')"
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <div class="inline-flex items-center gap-2">
                        <input
                            name="usable"
                            class="rounded-md"
                            id="usable"
                            type="checkbox"
                            value="1"
                            {{ old('usable') == 1 ? ' checked' : '' }}
                        />

                        <x-input-label class="" for="usable">{{ __('Active') }}</x-input-label>

                        <x-input-error class="mt-2" :messages="$errors->get('usable')" />
                    </div><!-- /.custom-control -->
                </div><!-- /.form-group -->

                <div class="mt-4">
                    @include('admin.permissions.partials.forms._permissions')
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-button light size="sm" bold type="submit">
                        {{ __('Save') }}
                    </x-button>
                </div><!-- /.form-group -->
            </form><!-- /form -->
        </div><!-- /.card-body -->
    </x-card><!-- /card -->
@endsection