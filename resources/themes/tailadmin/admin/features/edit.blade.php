@extends('admin.layouts.default')

@section('title', page_title(__('Edit Feature')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider mb-2">{{ __('Edit feature') }}</h4>

            <p class="text-sm text-slate-800">{{ __('Editing `:name` feature.', ['name' => $feature->name]) }}</p>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.features.update', $feature) }}">
                @csrf
                @method('PATCH')

                <div class="mt-4">
                    <x-input-label for="name">{{ __('Name') }}</x-input-label>

                    <x-input
                        class="w-full mt-2"
                        id="name"
                        type="text"
                        name="name"
                        placeholder="{{ __('Feature name, eg. Custom reports') }}"
                        value="{{ old('name', $feature->name) }}"
                        required
                        autofocus
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="key">{{ __('Key') }}</x-input-label>

                    <x-input
                        class="w-full mt-2"
                        id="key"
                        type="text"
                        name="key"
                        readonly
                        value="{{ old('key', $feature->key) }}"
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('key')" />
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
                        :value="old('description', $feature->description)"
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
                            {{ old('usable', $feature->usable) == 1 ? ' checked' : '' }}
                        />

                        <x-input-label class="" for="usable">{{ __('Active') }}</x-input-label>

                        <x-input-error class="mt-2" :messages="$errors->get('usable')" />
                    </div><!-- /.custom-control -->

                    <p class="mt-2 text-xs font-semibold text-slate-500">
                        {{ __('Uncheck if you do not want feature to be active') }}
                    </p>
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

@push('scripts')
    <script>
        $('input#key').keyup(function() {
            $(this).val(function (i, value) {
                return value.trim().toLowerCase().replace(/-|\s/g, '_');
            });
        }).focusout(function() {
            $(this).val(function (i, value) {
                return value.trim().toLowerCase().replace(/-|\s/g, '_');
            });
        });
    </script>
@endpush
