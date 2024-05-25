@extends('admin.layouts.default')

@section('title', page_title(__('Edit Role')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider mb-2">{{ __('Edit Role') }}</h4>

            <p class="text-sm text-slate-800">
                {!! __('Update :role role.', ['role' => "<strong>{$role->name}</strong>"]) !!}
            </p>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                @csrf
                @method('PATCH')

                <div class="mt-4">
                    <x-input-label for="name">{{ __('Name') }}</x-input-label>

                    <x-input
                        class="w-full mt-2"
                        id="name"
                        type="text"
                        name="name"
                        placeholder="{{ __('Role name') }}"
                        value="{{ old('name', $role->name) }}"
                        autofocus
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div><!-- /.form-group -->

                @include('admin.layouts.partials.forms._permitables', ['permitable' => $role->type])

                <div class="mt-4">
                    @include('admin.roles.partials.forms._parent_roles', [
                        'role_id' => $role->id,
                        'parent_id' => $role->parent_id,
                    ])
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="description">{{ __('Description') }}</x-input-label>

                    <x-textarea
                        class="w-full mt-2"
                        id="description"
                        name="description"
                        rows="3"
                        maxlength="255"
                        :placeholder="__('A short overview of what role entails')"
                        :value="old('description', $role->description)"
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <div class="inline-flex items-center gap-2">
                        <x-input
                            name="usable"
                            class="rounded-md"
                            id="usable"
                            type="checkbox"
                            value="1"
                            :checked="old('usable', $role->usable) == 1"
                        />

                        <x-input-label class="" for="usable">{{ __('Active') }}</x-input-label>

                        <x-input-error class="mt-2" :messages="$errors->get('usable')" />
                    </div><!-- /.custom-control -->
                </div><!-- /.form-group -->

                <div class="mt-4">
                    @include('admin.permissions.partials.forms._permissions', [
                        'permission_ids' => $role->permissions->pluck('id')->toArray()
                    ])
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
