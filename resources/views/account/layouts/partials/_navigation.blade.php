<ul class="flex flex-col mb-3 gap-y-1">
    <x-nav-pill :active="request()->routeIs('account.index')" href="{{ route('account.index') }}">
        {{ __('Account Overview') }}
    </x-nav-pill>
    <x-nav-pill :active="request()->routeIs('account.addresses.index')" href="{{ route('account.addresses.index') }}">
        {{ __('Addresses') }}
    </x-nav-pill>
    <x-nav-pill :active="request()->routeIs('account.profile.index')" href="{{ route('account.profile.index') }}">
        {{ __('Profile') }}
    </x-nav-pill>
    <x-nav-pill :active="request()->routeIs('account.password.index')" href="{{ route('account.password.index') }}">
        {{ __('Change Password') }}
    </x-nav-pill>
    <x-nav-pill :active="request()->routeIs('account.twofactor.index')" href="{{ route('account.twofactor.index') }}">
        {{ __('Two Factor Authentication') }}
    </x-nav-pill>
    <x-nav-pill :active="request()->routeIs('account.deactivate.index')" href="{{ route('account.deactivate.index') }}">
        {{ __('Deactivate Account') }}
    </x-nav-pill>
</ul>

<hr>

<ul class="flex flex-col mb-3 gap-y-1">
    <x-nav-pill :active="request()->routeIs('account.subscriptions.index')" href="{{ route('account.subscriptions.index') }}">
        {{ __('Manage Subscriptions') }}
    </x-nav-pill>

    @subscribed
        @subscriptionnotcancelled
            <x-nav-pill :active="request()->routeIs('account.subscriptions.swap.index')" href="{{ route('account.subscriptions.swap.index') }}">
                {{ __('Change Plan') }}
            </x-nav-pill>
            <x-nav-pill :active="request()->routeIs('account.subscriptions.cancel.index')" href="{{ route('account.subscriptions.cancel.index') }}">
                {{ __('Cancel Subscription') }}
            </x-nav-pill>
        @endsubscriptionnotcancelled

        @subscriptioncancelled
            <x-nav-pill :active="request()->routeIs('account.subscriptions.resume.index')" href="{{ route('account.subscriptions.resume.index') }}">
                {{ __('Resume Subscription') }}
            </x-nav-pill>
        @endsubscriptioncancelled

        <x-nav-pill :active="request()->routeIs('account.subscriptions.payment-methods.index')" href="{{ route('account.subscriptions.payment-methods.index') }}">
            {{ __('Update Card') }}
        </x-nav-pill>
    @endsubscribed
</ul>

<hr>

<ul class="flex flex-col mb-3 gap-y-1">
    <x-nav-pill :active="request()->routeIs('account.tokens.index')" href="{{ route('account.tokens.index') }}">
        {{ __('API Tokens') }}
    </x-nav-pill>
</ul>
