@extends('admin.layouts.default')

@section('title', page_title(__('Add Feature')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider mb-2">{{ __('Add new feature') }}</h4>

            <p class="text-sm text-slate-800">{{ __('Create a new app feature and link it to a plan.') }}</p>
        </x-slot><!-- /.card-header -->

        <div x-data="" class="card-body">
            <form method="POST" action="{{ route('admin.features.store') }}">
                @csrf

                <div class="mt-4">
                    <x-input-label for="name">{{ __('Name') }}</x-input-label>

                    <x-input class="w-full mt-2"
                       id="name"
                       type="text"
                       name="name"
                       placeholder="{{ __('Feature name, eg. Custom reports') }}"
                       value="{{ old('name') }}"
                       required
                       autofocus
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="key">{{ __('Key') }}</x-input-label>

                    <x-input class="w-full mt-2"
                       id="key"
                       type="text"
                       name="key"
                       placeholder="{{ __('A unique identifier for feature, eg. custom-reports') }}"
                       value="{{ old('key') }}"
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('key')" />

                    <p class="mt-2 text-xs font-semibold text-slate-500 text-danger">
                        {{ __('You cannot change this once feature is created.') }}
                    </p>
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="description">{{ __('Description') }}</x-input-label>

                    <x-textarea
                        class="w-full mt-2"
                        id="description"
                        name="description"
                        rows="3"
                        maxlength="255"
                        placeholder="{{ __('A detailed description of the feature') }}"
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
                            {{ old('usable', 1) == 1 ? ' checked' : '' }}
                        />

                        <x-input-label class="" for="usable">{{ __('Active') }}</x-input-label>

                        <x-input-error class="mt-2" :messages="$errors->get('usable')" />
                    </div><!-- /.custom-control -->

                    <p class="mt-2 text-xs font-semibold text-slate-500">
                        {{ __('Uncheck if you do not want feature to be active') }}
                    </p>
                </div><!-- /.form-group -->

                <div class="flex items-center gap-4 mt-4">
                    <x-button light size="sm" bold type="submit">
                        {{ __('Save') }}
                    </x-button>

                    <x-button light size="sm" bold variant="teal" type="submit" name="add_new" value="1">
                        {{ __('Save and Add new') }}
                    </x-button>
                </div><!-- /.form-group -->
            </form><!-- /form -->
        </div><!-- /.card-body -->
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
