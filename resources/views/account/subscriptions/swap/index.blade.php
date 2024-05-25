<x-account-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('Change Plan | Account')) }}
    </x-slot>

    <section>
        <x-card class="mb-4">
            <x-slot name="header">
                <h5 class="text-lg font-semibold tracking-wider mb-2">{{ __('Plans') }}</h5>

                <p class="text-xs text-slate-400">
                    {{ __('Take a quick look at plans below before swapping.') }}
                </p>
            </x-slot><!-- /.card-header -->

            <ul class="flex flex-col space-y-2">
                @foreach ($plans as $plan)
                    <li x-data class="flex justify-between items-center">
                        <p class="text-sm">
                            {{ $plan->name }}
                            <span class="font-semibold">({{ $plan->formatted_price }})</span>
                        </p>

                        <x-button
                            x-data=""
                            type="button"
                            rounded="md"
                            light
                            bold
                            title="More details on {{ $plan->name }} plan"
                            @click.prevent="$dispatch('open-modal', 'plan_{{ $plan->id }}_modal')"
                        >
                            {{ __('Features') }}
                        </x-link-button>
                    </li><!-- /.list-group-item -->

                    <x-plan-modal :plan="$plan" name="plan_{{ $plan->id }}_modal" />
                @endforeach
            </ul><!-- /.list-group -->
        </x-card><!-- /.card -->

        <x-card class="mb-4">
            <x-slot name="header">
                <h5 class="text-lg font-semibold tracking-wider mb-1">{{ __('Swap Subscription') }}</h5>

                <div class="inline-flex items-center text-sm gap-2">
                    <p>
                        {!! __('You are on the :plan plan.', ['plan' => "<strong>" . auth()->user()->plan->name . "</strong>"]) !!}
                    </p>

                    <x-button
                        x-data=""
                        type="button"
                        light
                        size="sm"
                        bold
                        rounded="md"
                        @click.prevent="$dispatch('open-modal', 'plan_{{ auth()->user()->plan->id }}_modal')">
                        {{ __('See features') }}
                    </x-button>
                </div>
            </x-slot><!-- /.card-header -->

            <div class="card-body">
                <form method="POST" action="{{ route('account.subscriptions.swap.store') }}">
                    @csrf

                    <div>
                        <x-input-label>{{ __('Choose a plan') }}</x-input-label>

                        <div class="flex flex-col mt-2 gap-4">
                            @foreach($plans as $index => $plan)
                                <div class="w-full p-2 inline-flex items-center gap-4">
                                    <input
                                        type="radio"
                                        name="plan"
                                        id="plan_{{ $plan->id }}"
                                        class=""
                                        {{ optional(auth()->user()->plan)->id == $plan->id || !auth()->user()->canDowngrade($plan) ? 'disabled' : '' }}
                                        {{ $plan->id == old('plan', $index == 0) ? 'checked' : '' }}
                                        value="{{ $plan->id }}"
                                    />
                                    <x-input-label for="plan_{{ $plan->id }}" class="custom-control-label">
                                        {{ $plan->name }} ({{ $plan->formatted_price }})
                                    </x-input-label>
                                </div>
                            @endforeach
                        </div>

                        <x-input-error class="mt-2" :messages="$errors->get('plan')" />
                    </div><!-- /.form-group -->

                    <div class="mt-4">
                        <x-button type="submit" light>
                            {{ __('Swap') }}
                        </x-button>
                    </div><!-- /.form-group -->
                </form><!-- /form -->

                <x-plan-modal :plan="auth()->user()->plan" name="plan_{{ auth()->user()->plan->id }}_modal" />
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section>
</x-account-layout>
