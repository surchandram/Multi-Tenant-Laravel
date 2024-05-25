@extends('admin.layouts.default')

@section('title', page_title(__('Edit User Role')))

@section('content')
    <x-card class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider mb-2">{{ $user->name }}</h4>

            <p class="text-sm text-slate-800">
                {!! __('Update user\'s :name role', ['name' => "<strong>{$role->name}</strong>"]) !!}
            </p>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.roles.update', [$user, $role]) }}">
                @csrf
                @method('PUT')

                <div class="mt-4">
                    <x-input-label>{{ __('Role') }}</x-input-label>

                    <x-input type="text" class="w-full mt-2" value="{{ $role->name }}" readonly />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="expires_at" class="mb-2">{{ __('Role expires at') }}</x-input-label>

                    <input
                        class="datetimepicker"
                        id="expires_at"
                        type="text"
                        name="expires_at"
                        placeholder="{{ __('date role expires at') }}"
                        value="{{ old('expires_at', optional($role->pivot)->expires_at) }}"
                    />

                    <p class="mt-2 text-xs font-semibold text-slate-500">{{ __('You can leave field as empty or set a date.') }}</p>

                    <x-input-error class="mt-2" :messages="$errors->get('expires_at')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-button light size="sm" bold type="submit">
                        {{ __('Update') }}
                    </x-button>
                </div><!-- /.form-group -->
            </form><!-- /form -->
        </div><!-- /.card-body -->
    </x-card><!-- /.card -->
@endsection
