@extends('admin.layouts.default')

@section('title', page_title(__('Add an app')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider mb-2">{{ __('Add new app') }}</h4>

            <p class="text-sm text-slate-800">{{ __('Create a new app and link it to a plan.') }}</p>
        </x-slot><!-- /.card-header -->

        <x-app-creator-form
            :apps="$apps"
            :features="$features"
            :plans="$plans"
        /><!-- /app creator form -->
    </x-card><!-- /card -->
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
