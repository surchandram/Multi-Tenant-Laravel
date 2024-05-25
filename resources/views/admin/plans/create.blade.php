@extends('admin.layouts.default')

@section('title', page_title(__('Add Plan')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider">{{ __('Add new plan') }}</h4>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.plans.store') }}">
                @csrf

                <div class="mt-4">
                    <x-input-label for="name">{{ __('Name') }}</x-input-label>

                    <x-input
                        class="w-full mt-2"
                        id="name"
                        type="text"
                        name="name"
                        placeholder="Plan name, eg. Monthly for 10"
                        value="{{ old('name') }}"
                        required
                        autofocus
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="interval">{{ __('Plan Interval') }}</x-input-label>

                    <x-select
                        id="interval"
                        class="w-full mt-2"
                        name="interval"
                    >
                        <option value="">{{ __('Select Interval') }}</option>
                        @foreach(\SAAS\Domain\Plans\Models\Plan::$intervals as $key => $interval)
                            <option value="{{ $key }}" {{ old('interval') == $key ? 'selected' : '' }}>
                                {{ __($interval) }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error class="mt-2" :messages="$errors->get('interval')" />
                </div>

                <div class="mt-4 mb-2">
                    <x-input-label for="provider_id">{{ __('Provider Id') }}</x-input-label>

                    <x-input
                        class="w-full mt-2"
                        id="provider_id"
                        type="text"
                        name="provider_id"
                        placeholder="{{ __('Plan id from provider, eg. monthly_10, team_50') }}"
                        value="{{ old('provider_id') }}"
                        required
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('provider_id')" />

                    <p class="mt-2 text-xs font-semibold text-slate-500">
                        {{ __('Provider id is used to identify the plan in your prefered payment provider') }}
                    </p>
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="price">{{ __('Price') }}</x-input-label>

                    <x-input
                        class="w-full mt-2"
                        id="price"
                        type="number"
                        name="price"
                        min="1"
                        placeholder="Plan price"
                        value="{{ old('price') }}"
                    />

                    <p class="inline-flex items-center gap-1 py-2 text-sm font-semibold">
                        {!! __('The plan price will be') !!} <span id="formatted_price" class="text-slate-800"></span>
                    </p>

                    <x-input-error class="mt-2" :messages="$errors->get('price')" />
                </div><!-- /.form-group -->

                <div class="py-4 mt-4">
                    <div class="inline-flex items-center gap-2">
                        <input
                            name="teams"
                            class="rounded-md"
                            id="teams"
                            type="checkbox"
                            value="1"
                            {{ old('teams') == 1 ? ' checked' : '' }}
                        />

                        <x-input-label for="teams">{{ __('For Teams') }}</x-input-label>

                        <x-input-error class="mt-2" :messages="$errors->get('teams')" />
                    </div><!-- /.custom-control -->

                    <p class="mt-2 text-xs font-semibold text-slate-500">{{ __('Leave unchecked if it is a user plan') }}</p>
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <div class="inline-flex items-center gap-2">
                        <input
                            name="per_seat"
                            class="rounded-md"
                            id="per_seat"
                            type="checkbox"
                            value="1"
                            {{ old('per_seat') == 1 ? ' checked' : '' }}
                        />

                        <x-input-label for="per_seat">{{ __('Per seat') }}</x-input-label>

                        <x-input-error class="mt-2" :messages="$errors->get('per_seat')" />
                    </div><!-- /.custom-control -->

                    <p class="mt-2 text-xs font-semibold text-slate-500">
                        {{ __('Charge subscription based on every user added.') }}
                    </p>
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="team_limit">{{ __('Team limit') }}</x-input-label>

                    <x-input
                        class="w-full mt-2"
                        id="team_limit"
                        type="number"
                        name="team_limit"
                        placeholder="{{ __('The maximum team users') }}"
                        value="{{ old('team_limit') }}"
                        min="1"
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('team_limit')" />

                    <p class="mt-2 text-xs font-semibold text-slate-500">
                        {{ __('Only applies if plan is for teams') }}
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
                        placeholder="{{ __('A short overview of the plan') }}"
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
                            {{ old('usable') == 1 ? ' checked' : '' }}
                        />

                        <x-input-label class="" for="usable">{{ __('Active') }}</x-input-label>

                        <x-input-error class="mt-2" :messages="$errors->get('usable')" />
                    </div><!-- /.custom-control -->
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
        document.addEventListener('DOMContentLoaded', function () {
            var $providerId = document.getElementById('provider_id');
            var $formattedPrice = document.getElementById('formatted_price');
            var $price = document.getElementById('price');
            const $options = { symbol: @js(env('CASHIER_CURRENCY_SYMBOL')), precision: 2, fromCents: true }

            $formattedPrice.textContent = currencyFormatter($price.value || 0, $options).format();

            document.getElementById('name').addEventListener('keyup', function(event) {
                $providerId.value = event.target.value.trim().toLowerCase().replace(/-|\s/g, '_');
            })

            $price.addEventListener('change', function(event) {
                $formattedPrice.textContent = currencyFormatter(
                    event.target.value,
                    $options
                ).format();
            })

            $providerId.addEventListener('keyup', function(event) {
                event.target.value = event.target.value.trim().toLowerCase().replace(/-|\s/g, '_');
            })

            $providerId.addEventListener('focusout', function(event) {
                event.target.value = event.target.value.trim().toLowerCase().replace(/-|\s/g, '_');
            });
        });
    </script>
@endpush
