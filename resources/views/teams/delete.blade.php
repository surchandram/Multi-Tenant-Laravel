<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__(':name | Teams', ['name' => $team->name])) }}
    </x-slot>


    <!-- Main -->
    <section class="">
        <x-card class="mb-4">
            <x-slot name="header">
                <h5 class="text-lg font-semibold mb-0">{{ __('Confirm team deletion') }}</h5>
            </x-slot>

            <form method="POST" action="{{ route('teams.destroy', $team) }}">
                @csrf
                @method('DELETE')

                {{ __('Are you sure you\'d like to delete \':name\'?', ['name' => $team->name]) }}
            </form>

            <x-slot name="footer" class="flex items-center justify-end gap-4">
                <x-danger-button type="submit">
                    {{ __('Yes, delete') }}
                </x-danger-button>

                <x-link-button
                    is-text="outline"
                    bold
                    uppercase
                    size="sm"
                    light="hover"
                    rounded="md"
                    ring
                    href="{{ route('teams.show', $team) }}"
                >
                    {{ __('Cancel') }}
                </x-link-button>
            </x-slot>
        </x-card><!-- /.col -->
    </section><!-- /.row -->
</x-team-layout>
