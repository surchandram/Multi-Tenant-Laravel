<ul class="flex flex-col mb-4">
    <x-nav-pill :active="request()->routeIs('tenant.home')" href="{{ route('tenant.home') }}">
        {{ __('Dashboard') }}
    </x-nav-pill>

    <x-nav-pill :active="request()->routeIs('tenant.projects.index')" href="{{ route('tenant.projects.index') }}">
        {{ __('Projects') }}
    </x-nav-pill>
</ul>

<ul class="flex flex-col">
    <x-nav-pill :active="request()->routeIs('tenant.teams.show')" href="{{ route('teams.show', tenant()) }}">
        {{ __('Account & Settings') }}
    </x-nav-pill>
</ul>
