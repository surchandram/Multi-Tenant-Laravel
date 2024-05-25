<x-account-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('Manage Subscriptions | Account')) }}
    </x-slot>

    <section>
        @if (!auth()->user()->hasSubscription())
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
                    <h5 class="text-lg font-semibold tracking-wider">{{ __('Subscription') }}</h5>
                </x-slot><!-- /.card-header -->

                <div class="card-body">
                    <form id="payment-form" method="POST" action="{{ route('account.subscriptions.store') }}">
                        @csrf

                        <div id="card-error" class="mb-1"></div>

                        <div>
                            <x-input-label for="card-holder-name">{{ __('Full name') }}</x-input-label>

                            <x-input type="text" id="card-holder-name" class="w-full mt-2" value="{{ auth()->user()->name }}" />
                        </div>

                        <div class="mt-4">
                            <x-input-label>{{ __('Choose a plan') }}</x-input-label>

                            <div class="flex flex-col mt-2 space-y-4">
                                @foreach ($plans as $index => $plan)
                                    <div class="w-full p-2 inline-flex items-center gap-4">
                                        <input
                                            type="radio"
                                            name="plan"
                                            id="plan_{{ $plan->id }}"
                                            class=""
                                            {{ $plan->id == old('plan', optional($choosenPlan)->id ?? $index == 0) ? 'checked' : '' }}
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

                        <div class="mt-4 mb-3">
                            <x-input-label class="mb-3">{{ __('Payment details') }}</x-input-label>

                            <!-- Stripe Elements Placeholder -->
                            <div id="card-element"></div>

                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div><!-- /.form-group -->

                        <div class="mt-4">
                            <x-input-label for="coupon">{{ __('Coupon code') }}</x-input-label>

                            <x-input
                                type="text"
                                id="coupon"
                                class="w-full mt-1"
                                name="coupon"
                                value="{{ old('coupon', request()->coupon) }}"
                                placeholder="enter a coupon code..."
                            />

                            <x-input-error :messages="$errors->get('coupon')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-button rounded="md" light bold size="sm" type="submit" id="card-button" class=""
                                data-secret="{{ optional(auth()->user()->createSetupIntent())->client_secret }}"
                            >
                                {{ __('Subscribe') }}
                            </x-button>
                        </div><!-- /.form-group -->
                    </form><!-- /form -->
                </div><!-- /.card-body -->
            </x-card><!-- /.card -->
        @else
            <!-- Subscription Info -->
            <x-card class="card mb-4">
                <x-slot name="header">
                    <h5 class="text-lg font-semibold tracking-wider">{{ __('Your Subscription') }}</h5>
                </x-slot>

                <div class="card-body">
                    <div class="w-full p-1 inline-flex items-center gap-2">
                        <p class="text-sm">
                            {!! __('You are on the :name plan.', ['name' => "<strong>". auth()->user()->plan->name . "</strong>"]) !!}
                        </p>
                        <x-button
                            x-data=""
                            type="button"
                            light
                            bold
                            size="sm"
                            rounded="md"
                            @click.prevent="$dispatch('open-modal', 'plan_{{ auth()->user()->plan->id }}_modal')"
                        >
                            {{ __('See features') }}
                        </x-button>
                    </div>

                    <x-plan-modal :plan="auth()->user()->plan" name="plan_{{ auth()->user()->plan->id }}_modal" />
                </div><!-- /.card-body -->
            </x-card><!-- /.card -->
        @endif

        <!-- Invoices Card -->
        <x-card class="card">
            <x-slot name="header">
                <h5 class="text-lg font-semibold tracking-wider">{{ __('Your Invoices') }}</h5>
            </x-slot>

            <div class="card-body">
                @if ($invoices->count())
                    <div class="table-responsive overflow-x-auto md:overflow-hidden">
                        <table class="table w-full">
                            @foreach ($invoices as $invoice)
                                <tr class="whitespace-nowrap">
                                    <td class="px-6 py-4">{{ $invoice->date()->toFormattedDateString() }}</td>
                                    <td class="px-6 py-4">{{ $invoice->total() }}</td>
                                    <td class="px-6 py-4">
                                        <x-link-button
                                            is-text="outline"
                                            ring
                                            light="hover"
                                            bold
                                            size="sm"
                                            rounded="md"
                                            href="{{ route('account.subscriptions.invoice.download', $invoice->id) }}"
                                        >
                                            {{ __('Download') }}
                                        </x-link-button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <p class="text-xs font-semibold text-slate-400">{{ __('No invoices.') }}</p>
                @endif
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section>
</x-account-layout>

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
