<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__('Subscriptions - :name - Teams', ['name' => $team->name])) }}
    </x-slot>

    <section class="space-y-4">
        @if ($team->hasNoSubscription())
            <!-- Plans -->
            <x-card class="mb-4">
                <x-slot name="header">
                    <h5 class="text-lg font-semibold tracking-wider mb-2">{{ __('Plans') }}</h5>

                    <p class="text-xs text-slate-400">
                        {{ __('Take a quick look at plans below before subscription.') }}
                    </p>
                </x-slot><!-- /.card-header -->

                <ul class="flex flex-col space-y-2">
                    @foreach ($plans as $plan)
                        <li x-data class="flex items-center justify-between">
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
                            </x-button>
                        </li><!-- /.list-group-item -->

                        <x-plan-modal :plan="$plan" name="plan_{{ $plan->id }}_modal" />
                    @endforeach
                </ul><!-- /.list-group -->
            </x-card><!-- /.card -->

            <!-- Subscription Card -->
            <x-card class="mb-4">
                <x-slot name="header">
                    <h5 class="text-lg font-semibold tracking-wider">{{ __('Subscriptions') }}</h5>
                </x-slot><!-- /.card-header -->

                <div class="card-body">
                    <x-validation-errors />

                    <form id="payment-form" method="POST" action="{{ route('teams.subscriptions.store', $team) }}">
                        @csrf

                        <div class="">
                            <x-input-label for="card-holder-name">{{ __('Full name') }}</x-input-label>

                            <x-input type="text" id="card-holder-name" class="w-full mt-1" value="{{ $team->name }}" />
                        </div>

                        <div class="mt-4">
                            <x-input-label>{{ __('Choose a plan') }}</x-input-label>

                            <div class="flex flex-col mt-2 space-y-4">
                                @foreach ($plans as $index => $plan)
                                    <div class="inline-flex items-center gap-4">
                                        <input
                                            type="radio"
                                            name="plan"
                                            id="plan_{{ $plan->id }}"
                                            class=""
                                            {{ $plan->id == old('plan', $index == 0) ? 'checked' : '' }}
                                            value="{{ $plan->id }}"
                                        />

                                        <x-input-label for="plan_{{ $plan->id }}" class="">
                                            {{ $plan->name }} ({{ $plan->formatted_price }})
                                        </x-input-label>
                                    </div>
                                @endforeach
                            </div>

                            <x-input-error :messages="$errors->get('plan')" class="mt-2" />
                        </div><!-- /.form-group -->

                        <div class="py-2 mt-4 mb-3">
                            <x-input-label>{{ __('Payment details') }}</x-input-label>

                            <!-- Stripe Elements Placeholder -->
                            <div id="card-element"></div>

                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div><!-- /.form-group -->

                        <div class="mt-4">
                            <x-input-label for="coupon">{{ __('Coupon code') }}</x-input-label>

                            <x-input
                                type="text"
                                id="coupon"
                                class="w-full mt-1 @error('coupon') is-invalid @enderror"
                                name="coupon"
                                value="{{ old('coupon', request()->coupon) }}"
                                placeholder="enter a coupon code..."
                            />

                            <x-input-error :messages="$errors->get('coupon')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-button rounded="md" light bold size="sm" type="submit" id="card-button" class=""
                                data-secret="{{ optional($team->createSetupIntent())->client_secret }}">
                                {{ __('Subscribe') }}
                            </x-button>
                        </div>
                    </form>
                </div><!-- /.card-body -->
            </x-card><!-- /.card -->
        @else
            <!-- Current Plan Details -->
            <x-card class="mb-4">
                <x-slot name="header">
                    <h5 class="text-lg font-semibold tracking-wider">{{ __('Team Subscription') }}</h5>
                </x-slot><!-- /.card-header -->

                <div class="card-body">
                    <p>
                        {!! __('You are on the :plan plan.', ['plan' => "<strong>{$team->plan->name}</strong>"]) !!}
                        <x-button
                            x-data=""
                            type="button"
                            light
                            bold
                            @click.prevent="$dispatch('open-modal', 'plan_{{ $team->plan->id }}_modal')"
                        >
                            {{ __('See features') }}
                        </x-button>
                    </p>

                    <x-plan-modal :plan="$team->plan" name="plan_{{ $team->plan->id }}_modal" />
                </div><!-- /.card-body -->
            </x-card><!-- /.card -->

            <!-- Swap Plan -->
            <x-card class="mb-4">
                <x-slot name="header">
                    <h5 class="text-lg font-semibold tracking-wider">{{ __('Swap Subscription') }}</h5>
                </x-slot><!-- /.card-header -->

                <div class="">
                    <div class="mb-3">
                        <x-team-plan-usage :team="$team" />
                    </div>

                    @include('layouts.partials.alerts._form_validation_alerts')

                    <form id="payment-form" method="POST" action="{{ route('teams.subscriptions.swap.store', $team) }}">
                        @csrf

                        <div class="mt-4">
                            <x-input-label>{{ __('Choose a plan') }}</x-input-label>

                            <div class="flex flex-col mt-3 gap-4">
                                @foreach ($plans as $index => $plan)
                                    <div class="p-1 inline-flex items-center gap-2">
                                        <input
                                            type="radio"
                                            name="plan"
                                            id="plan_{{ $plan->id }}"
                                            class="focus:ring focus:ring-blue-500"
                                            {{ optional($team->plan)->id == $plan->id || !$team->canDowngrade($plan) ? 'disabled' : '' }}
                                            {{ $team->isOnPlan($plan->provider_id) || $plan->id == old('plan', $index == 0) ? 'checked' : '' }}
                                            value="{{ $plan->id }}"
                                        >
                                        <x-input-label for="plan_{{ $plan->id }}" class="custom-control-label">
                                            {{ $plan->name }} ({{ $plan->formatted_price }})
                                        </x-input-label>
                                    </div>
                                @endforeach
                            </div>

                            <x-input-error :messages="$errors->get('plan')" class="mt-2" />
                        </div><!-- /.form-group -->

                        <div class="mt-4">
                            <x-button type="submit" light bold>
                                {{ __('Swap') }}
                            </x-button>
                        </div><!-- /.form-group -->
                    </form>
                </div><!-- /.card-body -->
            </x-card><!-- /.card -->

            <!-- todo: add invoices -->
        @endif
    </section>
</x-team-layout>

<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe(@js(config('services.stripe.key')));
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async (e) => {
        e.preventDefault()
        const { setupIntent, error } = await stripe.confirmCardSetup(clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: {
                    name: cardHolderName.value
                }
            }
        });

        if (error) {
            // Display "error.message" to the user...
            console.log(error.message)
            document.getElementById('card-error').innerText = error.message
            document.getElementById('card-button').disabled = false
        } else {
            let form = document.getElementById('payment-form')

            cardButton.disabled = true

            $input = document.createElement('input')
            $input.type = 'hidden'
            $input.name = 'payment_method'
            $input.value = setupIntent.payment_method

            form.append($input)

            form.submit()
        }
    });
</script>
