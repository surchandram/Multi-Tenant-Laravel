@extends('admin.layouts.default')

@section('title', page_title(__('Edit Plan')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider mb-2">{{ __('Edit plan') }}</h4>

            <p class="text-sm text-slate-800">
                {!! __('Update :plan plan details.', ['plan' => "<strong>{{ $plan->name }}</strong>"]) !!}
            </p>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.plans.update', $plan) }}">
                @csrf
                @method('PATCH')

                <div class="mt-4">
                    <x-input-label for="name">{{ __('Name') }}</x-input-label>

                    <x-input class="w-full mt-2 form-control-plaintext"
                        id="name"
                        type="text"
                        name="name"
                        value="{{ $plan->name }}"
                        readonly
                    />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="provider_id">{{ __('Provider Id') }}</x-input-label>

                    <x-input class="w-full mt-2 form-control-plaintext"
                        id="provider_id"
                        type="text"
                        name="provider_id"
                        value="{{ $plan->provider_id }}"
                        readonly
                    />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="price">{{ __('Price') }}</x-input-label>

                    <x-input
                        type="text"
                        name="price"
                        class="w-full mt-2 form-control-plaintext"
                        id="price"
                        value="{{ $plan->formatted_price }}"
                        readonly
                    />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="teams">{{ __('Type') }}</x-input-label>

                    <x-input
                        type="text"
                        name="teams"
                        class="w-full mt-2 form-control-plaintext"
                        id="teams"
                        value="{{ $plan->teams ? __('Teams') : __('Personal') }}"
                        readonly
                    />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="description">{{ __('Description') }}</x-input-label>

                    <x-textarea
                        class="w-full mt-2 form-control"
                        id="description"
                        name="description"
                        rows="3"
                        maxlength="255"
                        placeholder="A short overview of the plan"
                        :value="old('description', $plan->description)"
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
                            {{ old('usable', $plan->usable) == 1 ? ' checked' : '' }}
                        />

                        <x-input-label class="" for="usable">{{ __('Active') }}</x-input-label>
                    </div><!-- /.custom-control -->

                    <p class="mt-2 text-sm font-semibold text-slate-500">
                        {{ __('The current plan subscribers will still be billed under plan unless they cancel or swap.') }}
                    </p>

                    <x-input-error class="mt-2" :messages="$errors->get('usable')" />
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
