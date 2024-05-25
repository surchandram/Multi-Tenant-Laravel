<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__('Roles | :name | Teams', ['name' => $team->name])) }}
    </x-slot>

    <section>
        <x-card class="card mb-4" allow-overflow>
            <x-slot name="header">
                <div class="flex justify-between items-center">
                    <h5 class="text-lg font-semibold">{{ __('Roles') }}</h5>

                    <aside>
                        @can('assign team roles', $team)
                            <x-link-button href="{{ route('teams.roles.create', $team) }}" variant="teal" light rounded="md" size="xs" bold>
                                {{ __('Add a Role') }}
                            </x-link-button>
                        @endcan
                    </aside>
                </div>
            </x-slot><!-- /.card-header -->

            <div class="table-responsive-sm">
                <table class="w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-2 text-xs text-left text-gray-500" scope="col">{{ __('Name') }}</th>
                            <th class="px-6 py-2 text-xs text-left text-gray-500" scope="col">{{ __('Status') }}</th>
                            <th class="px-6 py-2 text-xs text-left text-gray-500" scope="col">{{ __('Users') }}</th>
                            <th class="px-6 py-2 text-xs text-left text-gray-500" scope="col">&nbsp;</th>
                        </tr>
                    </thead><!-- /thead -->
                    <tbody class="bg-slate-100 divide-y divide-gray-300">
                        @foreach ($team->roles as $role)
                            <tr class="whitespace-nowrap hover:bg-slate-200">
                                <th scope="row" class="px-6 py-4 text-sm text-left">
                                    {{ $role->name }}
                                </th>

                                <td class="px-6 py-4 text-sm text-left">
                                    {{ $role->usable ? __('Active') : __('Disabled') }}
                                </td>

                                <td class="px-6 py-4 text-sm text-left">
                                    {{ $role->users->count() }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{-- teamAdminRoleSlug | todo: switch in expression below --}}
                                    @if ($role->slug === \SAAS\App\Support\Roles::$roleWhenCreatingTeam)
                                        <div
                                            class="
                                                inline-flex
                                                flex-wrap
                                                px-2
                                                py-1
                                                text-sm
                                                rounded-full
                                                text-blue-500
                                                font-semibold
                                                bg-blue-200
                                                md:mr-14
                                                md:float-right
                                            "
                                        >
                                            {{ __('Default') }}
                                        </div>
                                    @else
                                        @can('assign team roles', $team)
                                            <x-dropdown align="left">
                                                <x-slot name="trigger">
                                                    <x-button
                                                        type="button"
                                                        size="sm"
                                                        bold
                                                        light="hover"
                                                        is-text="outline"
                                                        rounded="md"
                                                        aria-haspopup="true"
                                                        aria-expanded="false"
                                                        class="md:mr-12 md:float-right"
                                                    >
                                                        {{ __('Options') }}
                                                    </x-button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <div aria-labelledby="btnGroupDrop{{ $role->id }}">
                                                        <h6 class="px-4 py-2 text-xs font-semibold">
                                                            {{ $role->name }}
                                                        </h6>

                                                        <div class="my-2 border-t-2 border-slate-400"></div>

                                                        <x-dropdown-link class="dropdown-item"
                                                            href="{{ route('teams.roles.edit', [$team, $role]) }}">
                                                            {{ __('Edit') }}
                                                        </x-dropdown-link>

                                                        @if ($role->slug !== $team->teamAdminRoleSlug())
                                                            <div class="my-2 border-t-2 border-slate-400"></div>

                                                            <x-dropdown-link class="dropdown-item"
                                                                href="{{ route('teams.roles.status', [$team, $role]) }}"
                                                                onclick="event.preventDefault(); document.getElementById('status-role-{{ $role->id }}-form').submit();">
                                                                {{ $role->usable ? __('Disable') : __('Activate') }}
                                                            </x-dropdown-link>
                                                        @endif

                                                        @if (!$role->users->count())
                                                            <div class="my-2 border-t-2 border-slate-400"></div>
                                                            <x-dropdown-link class="dropdown-item"
                                                                href="{{ route('teams.roles.destroy', [$team, $role]) }}"
                                                                onclick="event.preventDefault(); confirmDelete('del-role-{{ $role->id }}-form', {{ json_encode($role) }});">
                                                                {{ __('Delete') }}
                                                            </x-dropdown-link>

                                                            <!-- Role Delete Form -->
                                                            <form id="del-role-{{ $role->id }}-form"
                                                                action="{{ route('teams.roles.destroy', [$team, $role]) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endif
                                                    </div>
                                                </x-slot>
                                            </x-dropdown><!-- /.btn-group -->

                                            <!-- Role Status Form -->
                                            <form id="status-role-{{ $role->id }}-form"
                                                action="{{ route('teams.roles.status', [$team, $role]) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('PATCH')
                                            </form>
                                        @endcan
                                    @endif
                                </td>
                            </tr><!-- /tr -->
                        @endforeach
                    </tbody><!-- /tbody -->
                </table><!-- /.table -->
            </div><!-- /.table-responsive -->
        </x-card><!-- /.card -->
    </section>

    @push('scripts')
        <script>
            function confirmDelete(id, role) {
                // find form
                var form = document.getElementById(id);

                // config
                let config = _.merge(swalCustomConfirmOptions, {
                    title: `<small>Are you sure you want to delete the <strong>${role.name}</strong> role?</small>`,
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    animation: false
                });

                // fire sweet alert
                Swal.fire(config).then((result) => {
                    if (result.value) {
                        // send request
                        form.submit();

                        // show alert
                        Toast.fire({
                            title: `${role.name} role is being deleted.`,
                            type: 'info'
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        FlashMessage.fire(
                            'Delete Action Cancelled',
                            'Your role is safe :)',
                            'info'
                        );
                    }
                })
            };
        </script>
    @endpush
</x-team-layout>
