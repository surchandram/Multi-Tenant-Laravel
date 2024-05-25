<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__('Resume Subscription - :name', ['name' => $team->name])) }}
    </x-slot>

    <section>
        <x-card class="card mb-4">
            <x-slot name="header">
                <h5 class="text-lg font-semibold">{{ __('Resume Subscription') }}</h5>
            </x-slot>

            <div class="card-body">
                <form method="POST" action="{{ route('teams.subscriptions.resume.store', $team) }}">
                    @csrf

                    <div class="form-group">
                        <label>{{ __('Enter your password') }}</label>

                        <x-input id="password" type="password" class="w-full mt-2" name="password" required
                            autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div><!-- /.form-group -->

                    <div class="mt-2">
                        <x-primary-button type="submit">
                            {{ __('Resume') }}
                        </x-primary-button>
                    </div><!-- /.form-group -->
                </form><!-- /form -->
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section><!-- /.row -->
</x-team-layout>
