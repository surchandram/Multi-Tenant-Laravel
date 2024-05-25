<x-account-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('Deactivate Account')) }}
    </x-slot>

    <x-card>
        <x-slot name="header">
            <h5 class="text-lg font-semibold">{{ __('Deactivate Account') }}</h5>
        </x-slot>

        <div>
            <form method="POST" action="{{ route('account.deactivate.store') }}">
                @csrf

                <div class="">
                    <x-input-label>{{ __('Enter your password') }}</x-input-label>

                    <x-input id="password" type="password" class="w-full mt-2" name="password" required
                        autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" />
                </div><!-- /.form-group -->

                <div class="mt-4">
                    @subscriptionnotcancelled
                        <p class="text-sm text-slate-800 font-semibold mb-4">
                            {{ __('This will also cancel your active subscription.') }}
                        </p>
                    @endsubscriptionnotcancelled

                    <x-danger-button type="submit">
                        {{ __('Deactivate Account') }}
                    </x-danger-button>
                </div><!-- /.form-group -->
            </form><!-- /form -->
        </div><!-- /.card-body -->
    </x-card><!-- /.card -->
</x-account-layout>
