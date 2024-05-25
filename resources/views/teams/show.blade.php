<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__(':name - Account Overview', ['name' => $team->name])) }}
    </x-slot>

    <section>
        <x-card class="mb-4">
            <x-slot name="header">
                <h5 class="text-lg font-semibold trackng-wider">{{ __('Account Overview') }}</h5>
            </x-slot>

            <div>
                {{ __('This is your team account area') }}
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section><!-- /.row -->
</x-team-layout>
