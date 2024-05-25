<ul class="flex flex-col mb-2">
    <x-nav-pill :active="request()->routeIs('dashboard')" href="{{ route('dashboard') }}">
        {{ __('Dashboard') }}
    </x-nav-pill>
    <x-nav-pill :active="request()->routeIs('dashboard.projects.index')"
        href="{{ route('dashboard.projects.index') }}">
        {{ __('Projects') }}
    </x-nav-pill>
</ul>

<ul class="flex flex-col mb-2">
    <x-nav-pill :active="request()->routeIs('teams.index')" href="{{ route('teams.index') }}">
        {{ __('Teams') }}
    </x-nav-pill>
</ul>
