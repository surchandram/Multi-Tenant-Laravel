<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__('Delete User | :name | Teams', ['name' => $team->name])) }}
    </x-slot>

    <section>
        <form method="POST" action="{{ route('teams.users.destroy', [$team, $user]) }}">
            @csrf
            @method('DELETE')

            <x-card class="card mb-4">
                <x-slot name="header" class="border-b border-gray-300">
                    <h5 class="text-lg font-semibold">{{ __('Confirm user deletion') }}</h5>
                </x-slot>

                <div class="text-sm">
                    {!! __('Are you sure you\'d like to delete \':name\' from \':team\'?', ['name' => "<strong>$user->name</strong>", 'team' => "<strong>$team->name</strong>"]) !!}
                </div><!-- /.card-body -->

                <x-slot name="footer">
                    <x-danger-button type="submit">
                        {{ __('Yes, delete') }}
                    </x-danger-button>

                    <x-link-button
                        is-text="outline"
                        size="sm"
                        light="hover"
                        rounded="md"
                        uppercase
                        href="{{ route('teams.users.index', $team) }}"
                    >
                        {{ __('Cancel') }}
                    </x-link-button>
                </x-slot>
            </x-card><!-- /.card -->
        </form>
    </section>
</x-team-layout>
