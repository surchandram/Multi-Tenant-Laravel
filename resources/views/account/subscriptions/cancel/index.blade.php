<x-account-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('Cancel Subscription | Account')) }}
    </x-slot>

    <section>
        <x-card class="mb-4">
            <x-slot name="header">
                <h5 class="text-lg font-semibold tracking-wider mb-1">{{ __('Cancel Subscription') }}</h5>

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
                <form method="POST" action="{{ route('account.subscriptions.cancel.store') }}">
                    @csrf

                    <div>
                        <x-input-label>{{ __('Enter your password') }}</x-input-label>

                        <x-input
                            id="password"
                            type="password"
                            class="w-full mt-2"
                            name="password"
                            required
                            autocomplete="new-password"
                        />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div><!-- /.form-group -->

                    <div class="mt-4">
                        <x-danger-button type="submit">
                            {{ __('Yes, Cancel Subscription') }}
                        </x-danger-button>
                    </div><!-- /.form-group -->
                </form><!-- /form -->

                <x-plan-modal :plan="auth()->user()->plan" name="plan_{{ auth()->user()->plan->id }}_modal" />
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section>
</x-account-layout>
