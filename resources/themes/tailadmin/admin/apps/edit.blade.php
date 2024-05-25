@extends('admin.layouts.default')

@section('title', page_title(__('Edit app')))

@section('content')
<!-- Actions -->
    <div x-data="" class="flex items-center justify-end gap-2 mb-4" role="group">
        <div class="text-lg font-semibold">{{ __('Actions') }}</div>

        <x-button
            type="button"
            size="sm"
            bg="teal"
            light
            bold
            rounded="md"
            @click="$scrollTo({ targetId: 'app_logo' })"
        >
            {{ __('Change logo') }}
        </x-button>

        <x-link-button themed
            size="sm"
            light
            bold
            rounded="md"
            href="{{ route('admin.apps.show', $app) }}"
        >
            {{ __('View') }}
        </x-link-button>
    </div>

    <!-- Header -->
    <x-card no-wrap-pad class="mb-5">
        {{-- <x-slot name="header" class="border-b"> --}}
            <h4 class="text-lg font-semibold tracking-wider mb-2">
            	{{ __('Editing: :app', ['app' => $app->name]) }}
            </h4>

            <p class="text-sm text-slate-800">{{ __('Update details below to match app changes.') }}</p>
        {{-- </x-slot> --}}
        <!-- /.card-header -->
    </x-card>

    <!-- Logo -->
    <x-card no-wrap-pad class="mb-5">
        <div id="logoCard">
        	<x-app-creator-form
        	    :route="route('admin.apps.update', $app)"
        	    :updating="true"
        	    :app="$app"
        	    :apps="$apps"
        	    :features="$features"
        	    :plans="$plans"
        	/><!-- /app creator form -->
        </div>
    </x-card><!-- /card -->

    <!-- Logo -->
    <x-card no-wrap-pad class="mb-5">
    	<h4 class="text-lg font-semibold">{{ __('App\'s Logo') }}</h4>

        <x-app-logo-form
            :route="route('admin.apps.logo.store', $app)"
            :app="$app"
        />
    </x-card>
@endsection

@push('scripts')
    <script>
        document.getElementById('name').addEventListener('keyup', function(event) {
            document.getElementById('key').value = (event.target.value.trim().toLowerCase().replace(/_|\s/g, '-'));
        });

        document.getElementById('key').addEventListener('keyup', function(event) {
            event.target.value = event.target.value.trim().toLowerCase().replace(/_|\s/g, '-');
        })
        document.getElementById('key').addEventListener('change', function(event) {
            event.target.value = event.target.value.trim().toLowerCase().replace(/_|\s/g, '-');
        })
        document.getElementById('key').addEventListener('focusout', function(event) {
            event.target.value = event.target.value.trim().toLowerCase().replace(/_|\s/g, '-');
        });
    </script>
@endpush
