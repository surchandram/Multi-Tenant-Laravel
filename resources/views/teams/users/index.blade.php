<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__('Users | :name | Teams', ['name' => $team->name])) }}
    </x-slot>


    <!-- Main -->
    <section>
        <x-card class="mb-4" allow-overflow>
            <x-slot name="header">
                <div class="flex justify-between items-center">
                    <h5 class="text-lg font-semibold">{{ __('Users') }}</h5>

                    <aside>
                        @can('add team user', $team)
                            @if ($team->hasNoSubscription())
                                <p class="mb-0">
                                    <x-link-button
                                        size="xs"
                                        bold
                                        light
                                        rounded="md"
                                        class="mr-2"
                                        href="{{ route('teams.subscriptions.index', $team) }}"
                                    >
                                        {{ __('Subscribe') }}
                                    </x-link-button>
                                    {{ __('to add users') }}
                                </p>
                            @elseif($team->hasReachedPlanLimit())
                                <p class="mb-0">
                                    <x-link-button
                                        size="xs"
                                        bold
                                        light
                                        rounded="md"
                                        class="mr-2"
                                        href="{{ route('teams.subscriptions.index', $team) }}"
                                    >
                                        {{ __('Upgrade') }}
                                    </x-link-button>
                                    {{ __('to add more members') }}
                                </p>
                            @else
                                <x-link-button
                                    size="xs"
                                    bold
                                    light
                                    rounded="md"
                                    class="mr-2"
                                    variant="teal"
                                    href="{{ route('teams.users.create', $team) }}">
                                    {{ __('Add User') }}
                                </x-link-button>
                            @endif
                        @endcan
                    </aside>
                </div>
            </x-slot>

            @if ($team->hasSubscription())
                <div class="py-2 mb-3">
                    <x-team-plan-usage :team="$team" />
                </div><!-- /.card-body -->
            @endif

            <div class="flex flex-col w-full">
                <div class="table-responsive-sm">
                    <table class="w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-2 text-xs text-left text-gray-500" scope="col">{{ __('Name') }}</th>
                                <th class="px-6 py-2 text-xs text-left text-gray-500" scope="col">{{ __('Role') }}</th>
                                <th class="px-6 py-2 text-xs text-left text-gray-500" scope="col">{{ __('Joined') }}</th>
                                <th class="px-6 py-2 text-xs text-left text-gray-500" scope="col">&nbsp;</th>
                            </tr>
                        </thead><!-- /thead -->
                        <tbody class="bg-white divide-y divide-gray-300">
                            @foreach ($users as $user)
                                <tr class="whitespace-nowrap">
                                    <th scope="row" class="px-6 py-4 text-sm text-left">
                                        <a href="{{ route('teams.users.show', [$team, $user]) }}">
                                            {{ $user->name }}
                                        </a>
                                    </th>
                                    <td class="px-6 py-4 text-sm text-left">
                                        {{ optional($user->roles->first())->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-left">
                                        {{ optional($user->pivot->created_at)->toFormattedDateString() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-dropdown align="top">
                                            <x-slot name="trigger">
                                                <x-button
                                                    href="#"
                                                    size="xs"
                                                    is-text="outline"
                                                    light="hover"
                                                    rounded="md"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                >
                                                    {{ __('Options') }}
                                                </x-button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <div aria-labelledby="btnGroupDrop{{ $user->id }}">
                                                    <h6 class="px-4 py-2 text-xs font-semibold text-green-500">
                                                        {{ $user->name }}
                                                    </h6>
                                                    @can('delete team user', $team)
                                                        <div class="my-2 border-t-2 border-slate-200"></div>

                                                        <x-dropdown-link class="dropdown-item"
                                                            href="{{ route('teams.users.roles.edit', [$team, $user]) }}">
                                                            {{ __('Change role') }}
                                                        </x-dropdown-link>
                                                    @endcan

                                                    @can('delete team user', $team)
                                                        @if (!$user->isOnlyAdminInTeam($team))
                                                            <div class="my-2 border-t-2 border-slate-200"></div>

                                                            <x-dropdown-link class="dropdown-item"
                                                                href="{{ route('teams.users.delete', [$team, $user]) }}">
                                                                {{ __('Delete user') }}
                                                            </x-dropdown-link>
                                                        @endif
                                                    @endcan
                                                </div><!-- /.dropdown-menu -->
                                            </x-slot>
                                        </x-dropdown><!-- /.btn-group -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
            </div>
        </x-card><!-- /.card -->

        <div class="py-2">
            {{ $users->onEachSide(2)->links() }}
        </div><!-- /.col -->
    </section><!-- /.row -->
</x-team-layout>
