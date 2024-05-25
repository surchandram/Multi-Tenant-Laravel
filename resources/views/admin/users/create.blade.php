@extends('admin.layouts.default')

@section('title', page_title(__('Add User')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider">{{ __('Add User') }}</h4>

            <p class="text-sm text-slate-800">
                {{ __('An invitation link will be emailed to the user to complete registration.') }}
            </p>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="mt-4">
                    <x-input-label for="name">{{ __('Name') }}</x-input-label>
                    <x-input
                        class="w-full mt-2 form-control"
                        id="name"
                        type="text"
                        name="name"
                        placeholder="name"
                        value="{{ old('name') }}"
                        autofocus
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="email">{{ __('Email Address') }}</x-input-label>
                    <x-input
                        class="w-full mt-2 form-control"
                        id="email"
                        type="email"
                        name="email"
                        placeholder="johndoe@example.org"
                        value="{{ old('email') }}"
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    @include('admin.roles.partials.forms._roles')
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="role_expires_at">{{ __('Role expires at') }}</x-input-label>
                    <x-input
                        class="datetimepicker form-control"
                        id="role_expires_at"
                        type="text"
                        name="role_expires_at"
                        placeholder="date role expires at"
                        value="{{ old('role_expires_at') }}"
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('role_expires_at')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-button light size="sm" bold type="submit">
                        {{ __('Invite') }}
                    </x-button>
                </div><!-- /.form-group -->
            </form><!-- /form -->
        </div><!-- /.card-body -->
    </x-card><!-- /card -->
@endsection
