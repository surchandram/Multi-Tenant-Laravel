<x-dashboard-layout>
    <x-slot name="pageTitle">{{ page_title(__('Teams')) }}</x-slot>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Teams') }}
            </h2>

            <div class="btn-group">
                <x-link-button variant="slate" light rounded="md" shades="800,700,700" bold href="{{ route('teams.create') }}">
                    {{ __('Create a Team') }}
                </x-link-button>
            </div>
        </div>
    </x-slot>

    <section>
        <x-card no-pad class="mb-4">
            <x-slot name="header" class="border-b border-gray-300">
                <div class="text-sm text-slate-500 font-semibold">
                    {{ __('List of teams you own or are a member.') }}
                </div>
            </x-slot>

            <div class="">
                @if ($teams->count())
                    <div class="flex flex-col">
                        @foreach ($teams as $team)
                            <div
                                class="
                                    px-4
                                    py-2
                                    flex
                                    justify-between
                                    items-center
                                    hover:bg-blue-100
                                    focus:bg-blue-100
                                    transition
                                    ease-in
                                    duration-75
                                "
                            >
                                <x-link-button
                                    no-margin
                                    size="sm"
                                    bold
                                    is-text
                                    variant="teal"
                                    shades="500,700,800"
                                    href="{{ route('tenant.switch', $team) }}"
                                >
                                    {{ $team->name }}
                                </x-link-button>

                                <div class="flex items-center gap-4">
                                    @if ($team->ownedByCurrentUser())
                                        <span class="px-4 py-1 text-sm text-blue-500 font-semibold bg-blue-200 rounded-full">
                                            {{ __('Admin') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div><!-- /.list-group -->
                @else
                    <p class="text-sm font-semibold">{{ __('You\'re not part of any team.') }}</p>
                @endif
            </div>
        </x-card><!-- /.card -->
    </section><!-- /.row -->
</x-dashboard-layout>
