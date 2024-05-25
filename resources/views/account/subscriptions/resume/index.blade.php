<x-account-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('Resume Subscription | Account')) }}
    </x-slot>

    <section>
        <x-card class="mb-4">
            <x-slot name="header">
                <h5 class="text-lg font-semibold tracking-wider">{{ __('Resume Subscription') }}</h5>
            </x-slot><!-- /.card-header -->

            <div class="card-body">
                <form method="POST" action="{{ route('account.subscriptions.resume.store') }}">
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
                        <x-button type="submit" light>
                            {{ __('Resume') }}
                        </x-button>
                    </div><!-- /.form-group -->
                </form><!-- /form -->
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section>
</x-account-layout>
