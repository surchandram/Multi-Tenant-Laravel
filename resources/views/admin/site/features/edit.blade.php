@extends('admin.layouts.default')

@section('title', page_title(__('Edit Feature')))

@section('content')
    <x-card class="mb-5">
        <x-slot name="header">
            <h4 class="text-lg font-semibold tracking-wider">{{ __('Edit homepage feature') }}</h4>

            <p class="text-sm text-slate-800">{{ __('Editing `:name` feature.', 'name' => $feature['name']) }}</p>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.site.features.update', $feature['slug']) }}">
                @csrf
                @method('PATCH')

                <div class="mt-4">
                    <x-input-label for="name">{{ __('Name') }}</x-input-label>
                    <x-input class="w-full mt-2"
                           id="name"
                           type="text"
                           name="name"
                           placeholder="{{ __('Feature name, eg. Custom reports') }}"
                           value="{{ old('name', $feature['name']) }}"
                           required
                           autofocus>

                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="overview">{{ __('Overview') }}</x-input-label>
                    <x-input class="w-full mt-2 form-control erview"
                           id="overview"
                           type="text"
                           name="overview"
                           placeholder="{{ __('What the feature does...') }}"
                           value="{{ old('overview', $feature['overview']) }}">

                    <x-input-error class="mt-2" :messages="$errors->get('overview')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="description">{{ __('Description') }}</x-input-label>
                    <x-textarea class="form-control scription"
                              id="description"
                              name="description"
                              rows="3"
                              placeholder="A detailed description of the feature">{{ old('description', $feature['description']) }}</x-textarea>

                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <div class="inline-flex items-center gap-2">
                        <input name="usable"
                               class=""
                               id="usable"
                               type="checkbox"
                               value="1"
                                {{ old('usable', $feature['usable']) == 1 ? 'checked' : '' }}>
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
