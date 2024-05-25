<ul class="flex flex-col gap-y-1 mb-4">
    <x-nav-pill class="nav-link" href="{{ route('tenant.switch', $team) }}">
        {{ __('Dashboard') }}
    </x-nav-pill>
</ul>

<ul class="flex flex-col gap-y-1 mb-4">
    <x-nav-pill :active="request()->routeIs('teams.show')" href="{{ route('teams.show', $team) }}">
        {{ __('Account Overview') }}
    </x-nav-pill>
    <x-nav-pill :active="request()->routeIs('teams.users.index')" href="{{ route('teams.users.index', $team) }}">
        {{ __('Users') }}
    </x-nav-pill>
    <x-nav-pill :active="request()->routeIs('teams.addresses.index')" href="{{ route('teams.addresses.index', $team) }}">
        {{ __('Addresses') }}
    </x-nav-pill>
</ul>

<ul class="flex flex-col gap-y-1 mb-4">
    @can('manage team subscriptions', $team)
        <x-nav-pill :active="request()->routeIs('teams.subscriptions.index')" href="{{ route('teams.subscriptions.index', $team) }}">
            {{ __('Subscriptions') }}
        </x-nav-pill>

        @if ($team->hasSubscription())
            @if ($team->hasNotCancelled())
                <x-nav-pill :active="request()->routeIs('teams.subscriptions.cancel.index')" href="{{ route('teams.subscriptions.cancel.index', $team) }}">
                    {{ __('Cancel Subscription') }}
                </x-nav-pill>
            @endif

            @if ($team->hasCancelled())
                <x-nav-pill :active="request()->routeIs('teams.subscriptions.resume.index')" href="{{ route('teams.subscriptions.resume.index', $team) }}">
                    {{ __('Resume Subscription') }}
                </x-nav-pill>
            @endif

            <x-nav-pill :active="request()->routeIs('teams.subscriptions.payment-methods.index')" href="{{ route('teams.subscriptions.payment-methods.index', $team) }}">
                {{ __('Update Card') }}
            </x-nav-pill>
        @endif
    @endcan
</ul>

<ul class="flex flex-col">
    @can('assign team roles', $team)
        <x-nav-pill :active="request()->routeIs('teams.roles.index')" href="{{ route('teams.roles.index', $team) }}">
            {{ __('Roles') }}
        </x-nav-pill>
    @endcan

    @can('delete team', $team)
        <x-nav-pill :active="request()->routeIs('teams.delete')" href="{{ route('teams.delete', $team) }}">
            {{ __('Delete Team') }}
        </x-nav-pill>
    @endcan
</ul>
