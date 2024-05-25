<header class="w-full h-16 flex items-center border-b border-gray-300 bg-white text-slate-800 fixed">
    <div class="md:w-60 inline-flex items-center md:justify-between">
        <x-button
            x-data=""
            is-text
            size="sm"
            class="md:hidden mr-auto md:mr-0"
            type="button"
            @click.prevent="$dispatch('sidebar-toggle')"
        >
            <x-navbar-toggler-icon />
        </x-button>

        <x-application-logo class="w-16 h-16 px-2 md:mr-2" />
        
        <x-link-button
            size="lg"
            bold
            is-text
            no-pad
            no-margin
            class="px-4 py-3 md:mr-auto"
            href="{{ route('home') }}"
        >
            {{ config('app.name') }}
        </x-link-button>
        
        <x-button
            x-data=""
            is-text
            class="hidden md:block"
            type="button"
            @click.prevent="$dispatch('sidebar-toggle-md')"
        >
            <x-navbar-toggler-icon />
        </x-button>
    </div>
    <!-- left -->
    <ul class="hidden lg:flex md:items-center">
        <li class="nav-item px-3">
            <x-link-button
                is-text
                size="sm"
                class="px-2 py-3"
                href="{{ route('admin.dashboard') }}"
            >
                {{ __('Dashboard') }}
            </x-link-button>
        </li>
    </ul>

    <!-- right -->
    <ul class="flex items-center ml-auto">
        <li class="hidden md:block nav-item px-3">
            <x-link-button is-text size="sm" class="px-2 py-3" href="{{ route('home') }}">{{ __('Home') }}</x-link-button>
        </li>

        <x-dropdown class="nav-item dropdown">
            <x-slot name="trigger">
                <x-button is-text size="sm" class="px-2 py-3" type="button" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ auth()->user()->avatar() }}" class="img-avatar" alt="{{ auth()->user()->name }}">
                </x-button>
            </x-slot>

            <x-slot name="content" class="">
                <x-dropdown-link class="" href="{{ route('dashboard') }}">
                    <i class="icon-speedometer"></i> {{ __('Your Dashboard') }}
                </x-dropdown-link>

                <x-dropdown-link class="" href="{{ route('account.index') }}">
                    <i class="icon-user"></i> {{ __('Your Account') }}
                </x-dropdown-link>

                <div class is-text="divider"></div>

                <x-dropdown-link class="" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="icon-logout"></i> {{ __('Logout') }}
                </x-dropdown-link>

                @include('layouts.partials.forms._logout')
            </x-slot>
        </x-dropdown>
    </ul>

    <x-button
        x-data=""
        is-text
        size="sm"
        ring
        type="button"
        @click.prevent="$dispatch('aside-menu-toggle')"
    >
        <x-navbar-toggler-icon />
    </x-button>
</header>
