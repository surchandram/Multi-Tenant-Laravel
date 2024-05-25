@extends('admin.layouts.default')

@section('title', page_title(__('Edit Plan Feature')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider mb-2">{{ __('Edit plan feature') }}</h4>

            <p class="text-sm text-slate-800">
                {!! __('Update the :feature feature under :plan plan.', ['feature' => "<strong>{{ $planFeature->name }}</strong>", 'plan' => "<strong>{{ $plan->name }}</strong>"]) !!}
            </p>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.plans.features.update', [$plan, $planFeature]) }}">
                @csrf
                @method('PATCH')

                <div class="mt-4">
                    <x-input-label for="feature">{{ __('Feature') }}</x-input-label>

                    <x-input class="w-full mt-2 form-control-plaintext"
                        id="feature"
                        type="text"
                        name="feature"
                        value="{{ $planFeature->feature->name }}"
                        readonly
                    />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="limit">{{ __('Limit') }}</x-input-label>

                    <x-input class="w-full mt-2 form-control mit"
                        id="limit"
                        type="number"
                        name="limit"
                        min="0"
                        placeholder="Feature limit"
                        value="{{ old('limit', $planFeature->limit) }}"
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
                            {{ old('default', $planFeature->default) == 1 ? ' checked' : '' }}
                        />

                        <x-input-label class="" for="default">{{ __('Set as default') }}</x-input-label>

                        <x-input-error class="mt-2" :messages="$errors->get('default')" />
                    </div><!-- /.custom-control -->

                    <p class="mt-2 text-xs font-semibold text-slate-500">
                        {{ __('Check if you want feature to be the default for plan') }}
                    </p>
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-button light size="sm" bold type="submit">
                        {{ __('Update') }}
                    </x-button>
                </div><!-- /.form-group -->
            </form><!-- /form -->
        </div><!-- /.card-body -->
    </x-card><!-- /card -->
@endsection
