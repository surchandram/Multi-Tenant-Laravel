@extends('admin.layouts.default')

@section('title', page_title(__('Impersonate User')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider mb-2">{{ __('Impersonate User') }}</h4>

            <p class="text-sm text-slate-800">
                {{ __('Enter the email of the user you want to impersonate.') }}
            </p>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.impersonate.store') }}">
                @csrf

                <div class="flex flex-col md:grid md:grid-cols-3">
                    <x-input-label for="email" class="md:col-span-1">{{ __('Email Address') }}</x-input-label>

                    <div class="md:col-span-2">
                        <x-input
                            id="email"
                            type="email"
                            class="w-full mt-2"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="new-email"
                        />

                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                </div><!-- /.form-group -->

                <div class="flex flex-col mt-4 md:grid md:grid-cols-3">
                    <div class="md:col-start-2">
                        <x-button type="submit" light size="sm" class="">
                            {{ __('Impersonate') }}
                        </x-button>
                    </div>
                </div><!-- /.form-group -->
            </form>
        </div><!-- /.card-body -->
    </x-card><!-- /.card -->
@endsection
