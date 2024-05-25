@extends('admin.layouts.default')

@section('title', page_title(__('Add Plan Feature')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider mb-2">{{ __('Add new feature') }}</h4>

            <p class="text-sm text-slate-800">
                {!! __('Add a new feature to :plan plan.', ['plan' => "<strong>{{ $plan->name }}</strong>"]) !!}
            </p>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.plans.features.store', $plan) }}">
                @csrf

                <div class="mt-4">
                    <x-input-label for="feature">{{ __('Feature') }}</x-input-label>

                    <x-select class="w-full mt-2" id="feature" name="feature">
                        <option value="">{{ __('Choose a feature') }}</option>
                        @foreach($features as $feature)
                            <option value="{{ $feature->id }}"
                                {{ old('feature') == $feature->id ? 'selected' : '' }}
                                {{ $plan->hasFeature($feature) ? 'disabled' : '' }}
                            >
                                {{ $feature->name }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error class="mt-2" :messages="$errors->get('feature')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="limit">{{ __('Limit') }}</x-input-label>

                    <x-input
                        class="w-full mt-2"
                        id="limit"
                        type="number"
                        name="limit"
                        min="0"
                        placeholder="Feature limit"
                        value="{{ old('limit') }}"
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('limit')" />

                    <p class="mt-2 text-xs font-semibold text-slate-500">
                        {{ __('Leave null or set to zero for unlimited.') }}
                    </p>
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <div class="inline-flex items-center gap-2">
                        <input name="default"
                            class="rounded-md default"
                            id="default"
                            type="checkbox"
                            value="1"
                            {{ old('default') == 1 ? ' checked' : '' }}
                        />

                        <x-input-label class="" for="default">{{ __('Set as default') }}</x-input-label>

                        <x-input-error class="mt-2" :messages="$errors->get('default')" />
                    </div><!-- /.custom-control -->

                    <p class="mt-2 text-xs font-semibold text-slate-500">
                        {{ __('Check if you want feature to be the default for plan') }}
                    </p>
                </div><!-- /.form-group -->

                <div class="flex items-center gap-4 mt-4">
                    <x-button light size="sm" bold type="submit">
                        {{ __('Save') }}
                    </x-button>

                    <x-button light size="sm" bold bg="teal" type="submit" name="add_new" value="1">
                        {{ __('Save and Add new') }}
                    </x-button>
                </div><!-- /.form-group -->
            </form><!-- /form -->
        </div><!-- /.card-body -->
    </x-card><!-- /card -->
@endsection
