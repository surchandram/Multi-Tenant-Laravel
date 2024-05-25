<x-dashboard-layout>
    @section('title', page_title(__('Teams')))

    @section('header')
        <div class="flex justify-between items-center p-4 md:p-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Teams') }}
            </h2>

            <div class="btn-group">
                <x-link-button themed themed rounded="md" href="{{ route('teams.create') }}">
                    {{ __('Create a Team') }}
                </x-link-button>
            </div>
        </div>
    @endsection

    @section('content')
        <section>
            <x-card no-pad allow-overflow class="mb-4">
                <x-slot name="header" class="border-b border-gray-300">
                    <div class="text-sm text-slate-500 font-semibold">
                        {{ __('List of teams you own or are a member.') }}
                    </div>
                </x-slot>

                <div>
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
                                    <x-link-button themed
                                        no-margin
                                        size="sm"
                                        bold
                                        is-text
                                        bg="teal"
                                        shades="500,700,800"
                                        href="{{ route('tenant.switch', $team) }}"
                                    >
                                        {{ $team->name }}
                                    </x-link-button>

                                    <div class="flex items-center gap-4">
                                        @if ($team->ownedByCurrentUser())
                                            <div class="block px-4 py-1 text-sm bg-primary text-bodydark1 font-semibold rounded-full">
                                                {{ __('Admin') }}
                                            </div>
                                        @endif

                                        <div class="relative">
                                            <x-dropdown>
                                                <x-slot name="trigger">
                                                    <x-button type="button" themed is-text class="focus:ring">
                                                        {{ __('Options') }} <i class="bi bi-chevron-down"></i>
                                                    </x-button>
                                                </x-slot>
                                            
                                                <x-slot name="content">
                                                    <x-dropdown-link
                                                        href="{{ route('teams.show', $team) }}"
                                                    >
                                                        {{ __('Settings') }}
                                                    </x-dropdown-link>
                                                    <x-dropdown-link
                                                        href="{{ route('teams.addresses.index', $team) }}"
                                                    >
                                                        {{ __('Update Address') }}
                                                    </x-dropdown-link>
                                                </x-slot>
                                            </x-dropdown>
                                        </div>
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
    @endsection
</x-dashboard-layout>
