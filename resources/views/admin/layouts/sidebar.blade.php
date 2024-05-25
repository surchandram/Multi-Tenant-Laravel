{{-- sidebar --}}
<div
    x-data="{
        open: false,
        openedMd: true,
        minimize: false,
        get openState() {
            return this.open || this.openedMd
        },
        handleToggle() {
            this.open = !this.open
            this.minimize = false
            this.$dispatch('sidebar-is-open', this.open)
        },
        handleToggleMd() {
            this.openedMd = !this.openedMd
            this.minimize = false
            this.$dispatch('sidebar-is-open-md', this.openedMd)
        },
        handleMinimize() {
            this.minimize = !this.minimize
            this.open = false
            this.$dispatch('sidebar-is-open', this.open)
        },
        init() {
            this.$dispatch('sidebar-is-open', this.open)
            this.$dispatch('sidebar-is-open-md', this.openedMd)
        }
    }"
    class="w-3/4 md:w-60 h-full hidden flex-col pb-24 fixed z-30 overflow-hidden"
    :class="{
        'flex': open,
        'hidden': ! open,
        'md:flex': openedMd,
        'md:hidden': ! openedMd
    }"
    x-on:sidebar-toggle.window="handleToggle"
    x-on:sidebar-toggle-md.window="handleToggleMd"
    x-on:minimize-sidebar.window="handleMinimize"
>
    {{--  sidebar-nav --}}
    <nav class="h-full pb-8 bg-slate-700 text-slate-400 sidebar-wrapper">
        <ul class="flex flex-col h-full overflow-y-scroll">
            <li class="nav-item">
                <x-admin-sidebar-link
                    route="admin.dashboard"
                    href="{{ route('admin.dashboard') }}"
                >
                    <i class="nav-icon text-xl icon-speedometer"></i> {{ __('Dashboard') }}
                </x-admin-sidebar-link>
            </li><!-- /.nav-item -->

            <!-- Features -->
            <li
                x-data="{
                    open: @js(
                        request()->routeIs('admin.features.create', 'admin.features.index')
                    )
                }"
                class="nav-item nav-dropdown"
            >
                <x-link-button
                    no-pad
                    no-margin
                    light
                    variant="slate"
                    shades="700,600,800"
                    size="sm"
                    class="w-full inline-flex items-center px-4 py-3 gap-2 nav-link nav-dropdown-toggle"
                    href="#"
                    @click.prevent="open = !open"
                >
                    <i class="nav-icon text-xl icon-diamond"></i> {{ __('Features') }} <x-dropdown-toggler-icon class="ml-auto" />
                </x-link-button>

                <ul class="flex flex-col" style="display: none;" x-show="open">
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.features.create"
                            href="{{ route('admin.features.create') }}"
                        >
                            <i class="nav-icon text-xl icon-plus"></i> {{ __('Add Feature') }}
                        </x-admin-sidebar-link>
                    </li>
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.features.index"
                            href="{{ route('admin.features.index') }}"
                        >
                            <i class="nav-icon text-xl icon-diamond"></i> {{ __('Features') }}
                        </x-admin-sidebar-link>
                    </li>
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Apps -->
            <li
                x-data="{
                    open: @js(
                        request()->routeIs('admin.apps.create', 'admin.apps.index')
                    )
                }"
                class="nav-item nav-dropdown"
            >
                <x-link-button
                    no-pad
                    no-margin
                    light
                    variant="slate"
                    shades="700,600,800"
                    size="sm"
                    class="w-full inline-flex items-center px-4 py-3 gap-2 nav-link nav-dropdown-toggle"
                    href="#"
                    @click.prevent="open = !open"
                >
                    <i class="nav-icon text-xl icon-rocket"></i>
                    {{ __('Apps') }} <x-dropdown-toggler-icon class="ml-auto" />
                </x-link-button>

                <ul class="flex flex-col" style="display: none;" x-show="open">
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.apps.create"
                            href="{{ route('admin.apps.create') }}"
                        >
                            <i class="nav-icon text-xl icon-plus"></i> {{ __('Add App') }}
                        </x-admin-sidebar-link>
                    </li>
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.apps.index"
                            href="{{ route('admin.apps.index') }}"
                        >
                            <i class="nav-icon text-xl icon-rocket"></i>
                            {{ __('Apps') }}
                        </x-admin-sidebar-link>
                    </li>
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Plans -->
            <li
                x-data="{
                    open: @js(
                        request()->routeIs('admin.plans.create', 'admin.plans.index')
                    )
                }"
                class="nav-item nav-dropdown"
            >
                <x-link-button
                    no-pad
                    no-margin
                    light
                    variant="slate"
                    shades="700,600,800"
                    size="sm"
                    class="w-full inline-flex items-center px-4 py-3 gap-2 nav-link nav-dropdown-toggle"
                    href="#"
                    @click.prevent="open = !open"
                >
                    <i class="nav-icon text-xl icon-credit-card"></i> {{ __('Plans') }} <x-dropdown-toggler-icon class="ml-auto" />
                </x-link-button>

                <ul class="flex flex-col" style="display: none;" x-show="open">
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.plans.create"
                            href="{{ route('admin.plans.create') }}"
                        >
                            <i class="nav-icon text-xl icon-plus"></i> {{ __('Add Plan') }}
                        </x-admin-sidebar-link>
                    </li>
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.plans.index"
                            href="{{ route('admin.plans.index') }}"
                        >
                            <i class="nav-icon text-xl icon-credit-card"></i> {{ __('Plans') }}
                        </x-admin-sidebar-link>
                    </li>
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Users -->
            <li class="px-4 py-1 text-xs font-semibold uppercase">{{ __('USERS & ACCESS CONTROL') }}</li>
            <li
                x-data="{
                    open: @js(
                        request()->routeIs('admin.users.create', 'admin.users.index')
                    )
                }"
                class="nav-item nav-dropdown"
            >
                <x-link-button
                    no-pad
                    no-margin
                    light
                    variant="slate"
                    shades="700,600,800"
                    size="sm"
                    class="w-full inline-flex items-center px-4 py-3 gap-2 nav-link nav-dropdown-toggle"
                    href="#"
                    @click.prevent="open = !open"
                >
                    <i class="nav-icon text-xl icon-people"></i> {{ __('Users') }} <x-dropdown-toggler-icon class="ml-auto" />
                </x-link-button>

                <ul class="flex flex-col" style="display: none;" x-show="open">
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.users.create"
                            href="{{ route('admin.users.create') }}"
                        >
                            <i class="nav-icon text-xl icon-plus"></i> {{ __('Add User') }}
                        </x-admin-sidebar-link>
                    </li>

                    <!-- Impersonate User -->
                    {{--@role('admin-root')--}}
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.users.impersonate"
                            href="{{ route('admin.users.impersonate.index') }}"
                        >
                            <i class="nav-icon text-xl icon-user"></i> {{ __('Impersonate User') }}
                        </x-admin-sidebar-link>
                    </li>
                    {{--@endrole--}}

                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.users.index"
                            href="{{ route('admin.users.index') }}"
                        >
                            <i class="nav-icon text-xl icon-people"></i> {{ __('Users') }}
                        </x-admin-sidebar-link>
                    </li>

                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.users.restore"
                            href="{{ route('admin.users.restore.index') }}"
                        >
                            <i class="nav-icon text-xl icon-exclamation"></i> {{ __('Deactivated Users') }}
                        </x-admin-sidebar-link>
                    </li>
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Permissions -->
            <li
                x-data="{
                    open: @js(
                        request()->routeIs('admin.permissions.create', 'admin.permissions.index')
                    )
                }"
                class="nav-item nav-dropdown"
            >
                <x-link-button
                    no-pad
                    no-margin
                    light
                    variant="slate"
                    shades="700,600,800"
                    size="sm"
                    class="w-full inline-flex items-center px-4 py-3 gap-2 nav-link nav-dropdown-toggle"
                    href="#"
                    @click.prevent="open = !open"
                >
                    <i class="nav-icon text-xl icon-flag"></i> {{ __('Permissions') }} <x-dropdown-toggler-icon class="ml-auto" />
                </x-link-button>

                <ul class="flex flex-col" style="display: none;" x-show="open">
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.permissions.create"
                            href="{{ route('admin.permissions.create') }}"
                        >
                            <i class="nav-icon text-xl icon-plus"></i> {{ __('Add Permission') }}
                        </x-admin-sidebar-link>
                    </li>
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.permissions.index"
                            href="{{ route('admin.permissions.index') }}"
                        >
                            <i class="nav-icon text-xl icon-flag"></i> {{ __('Permissions') }}
                        </x-admin-sidebar-link>
                    </li>
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Roles -->
            <li
                x-data="{
                    open: @js(
                        request()->routeIs('admin.roles.create', 'admin.roles.index')
                    )
                }"
                class="nav-item nav-dropdown"
            >
                <x-link-button
                    no-pad
                    no-margin
                    light
                    variant="slate"
                    shades="700,600,800"
                    size="sm"
                    class="w-full inline-flex items-center px-4 py-3 gap-2 nav-link nav-dropdown-toggle"
                    href="#"
                    @click.prevent="open = !open"
                >
                    <i class="nav-icon text-xl icon-lock"></i> {{ __('Roles') }} <x-dropdown-toggler-icon class="ml-auto" />
                </x-link-button>

                <ul class="flex flex-col" style="display: none;" x-show="open">
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.roles.create"
                            href="{{ route('admin.roles.create') }}"
                        >
                            <i class="nav-icon text-xl icon-plus"></i> {{ __('Add Role') }}
                        </x-admin-sidebar-link>
                    </li>
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.roles.index"
                            href="{{ route('admin.roles.index') }}"
                        >
                            <i class="nav-icon text-xl icon-lock"></i> {{ __('Roles') }}
                        </x-admin-sidebar-link>
                    </li>
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Support -->
            <li class="px-4 py-1 text-xs font-semibold uppercase">{{ __('SUPPORT') }}</li>

            <!-- Ticket Categories -->
            <li
                x-data="{
                    open: @js(
                        request()->routeIs(
                            'admin.support.tickets.categories.create',
                            'admin.support.tickets.categories.index'
                        )
                    )
                }"
                class="nav-item nav-dropdown"
            >
                <x-link-button
                    no-pad
                    no-margin
                    light
                    variant="slate"
                    shades="700,600,800"
                    size="sm"
                    class="w-full inline-flex items-center px-4 py-3 gap-2 nav-link nav-dropdown-toggle"
                    href="#"
                    @click.prevent="open = !open"
                >
                    <i class="nav-icon text-xl icon-layers"></i>
                    {{ __('Ticket Categories') }}
                    <x-dropdown-toggler-icon class="ml-auto" />
                </x-link-button>

                <ul class="flex flex-col" style="display: none;" x-show="open">
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.support.tickets.categories.index"
                            href="{{ route('admin.support.tickets.categories.create') }}"
                        >
                            <i class="nav-icon text-xl icon-plus"></i>
                            {{ __('Add Category') }}
                        </x-admin-sidebar-link>
                    </li><!-- /.nav-item -->
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.support.tickets.categories.index"
                            href="{{ route('admin.support.tickets.categories.index') }}"
                        >
                            <i class="nav-icon text-xl icon-layers"></i>
                            {{ __('Ticket Categories') }}
                        </x-admin-sidebar-link>
                    </li><!-- /.nav-item -->
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Ticket Labels -->
            <li
                x-data="{
                    open: @js(
                        request()->routeIs(
                            'admin.support.tickets.labels.create',
                            'admin.support.tickets.labels.index'
                        )
                    )
                }"
                class="nav-item nav-dropdown"
            >
                <x-link-button
                    no-pad
                    no-margin
                    light
                    variant="slate"
                    shades="700,600,800"
                    size="sm"
                    class="w-full inline-flex items-center px-4 py-3 gap-2 nav-link nav-dropdown-toggle"
                    href="#"
                    @click.prevent="open = !open"
                >
                    <i class="nav-icon text-xl icon-tag"></i>
                    {{ __('Ticket Labels') }}
                    <x-dropdown-toggler-icon class="ml-auto" />
                </x-link-button>

                <ul class="flex flex-col" style="display: none;" x-show="open">
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.support.tickets.labels.index"
                            href="{{ route('admin.support.tickets.labels.create') }}"
                        >
                            <i class="nav-icon text-xl icon-plus"></i>
                            {{ __('Add Label') }}
                        </x-admin-sidebar-link>
                    </li><!-- /.nav-item -->
                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.support.tickets.labels.index"
                            href="{{ route('admin.support.tickets.labels.index') }}"
                        >
                            <i class="nav-icon text-xl icon-tag"></i>
                            {{ __('Ticket Labels') }}
                        </x-admin-sidebar-link>
                    </li><!-- /.nav-item -->
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Tickets -->
            <li
                x-data="{
                    open: @js(request()->routeIs('admin.support.tickets.index'))
                }"
                class="nav-item nav-dropdown"
            >
                <x-link-button
                    no-pad
                    no-margin
                    light
                    variant="slate"
                    shades="700,600,800"
                    size="sm"
                    class="w-full inline-flex items-center px-4 py-3 gap-2 nav-link nav-dropdown-toggle"
                    href="#"
                    @click.prevent="open = !open"
                >
                    <i class="nav-icon text-xl icon-support"></i>
                    {{ __('Tickets') }}
                    <x-dropdown-toggler-icon class="ml-auto" />
                </x-link-button>

                <ul class="flex flex-col" style="display: none;" x-show="open">
                    <!-- Priority Filters -->
                    <li class="px-4 py-1 text-xs font-semibold uppercase">
                        {{ __('Priority Filters') }}
                    </li>

                    @foreach (\Saasplayground\SupportTickets\SupportTickets::getPriorityMap() as $priority)
                        <li class="nav-item">
                            <x-admin-sidebar-link
                                href="{{ route('admin.support.tickets.index', ['priority' => $priority]) }}"
                                :current="\Illuminate\Support\Arr::has(array_keys(request()->query()), $priority)"
                            >
                                <i class="nav-icon text-xl text-red-{{ 700 - ($loop->index*100) }} icon-flag"></i> 
                                {{ \Illuminate\Support\Str::title($priority) }}
                            </x-admin-sidebar-link>
                        </li>
                        {{-- empty expr --}}
                    @endforeach

                    <li class="nav-item">
                        <x-admin-sidebar-link
                            route="admin.support.tickets.index"
                            href="{{ route('admin.support.tickets.index') }}"
                        >
                            <i class="nav-icon text-xl icon-support"></i>
                            {{ __('Tickets') }}
                        </x-admin-sidebar-link>
                    </li><!-- /.nav-item -->
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Site -->
            {{-- <li class="px-4 py-1 text-xs font-semibold uppercase">{{ __('SITE') }}</li> --}}
            <!-- Settings -->
            {{-- <li class="nav-item">
                <x-admin-sidebar-link
                    route="admin.settings.index"
                    href="{{ route('admin.settings.index') }}"
                >
                    <i class="nav-icon text-xl icon-settings"></i> {{ __('Settings') }}
                </x-admin-sidebar-link>
            </li><!-- /.nav-item --> --}}
        </ul><!-- /.nav -->
    </nav><!-- /.sidebar-nav -->
</div><!-- /.sidebar -->
