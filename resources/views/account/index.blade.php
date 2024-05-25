<x-account-layout>

    <x-slot name="pageTitle">
        {{ page_title(__('Account Overview')) }}
    </x-slot>

    <x-card no-pad>
        <x-slot name="header">
            <h4 class="text-lg font-semibold">{{ __('Account Overview') }}</h4>
        </x-slot>

        <div class="flex flex-col divide-y divide-gray-300">
            <div class="px-6 py-2">
                <h4 class="mb-2 text-xs text-slate-400 font-semibold">{{ __('Name') }}</h4>
                <p class="text-lg text-slate-800 font-semibold">{{ auth()->user()->name }}</p>
            </div>
            <div class="px-6 py-2">
                <h4 class="mb-2 text-xs text-slate-400 font-semibold">{{ __('Email Address') }}</h4>
                <p class="text-lg text-slate-800 font-semibold">{{ auth()->user()->email }}</p>
            </div>
            <div class="px-6 py-2">
                <h4 class="mb-2 text-xs text-slate-400 font-semibold">{{ __('Joined') }}</h4>
                <p class="text-lg text-slate-800 font-semibold">{{ auth()->user()->created_at->diffForHumans() }}</p>
            </div>
            <div class="px-6 py-2">
                <h4 class="mb-2 text-xs text-slate-400 font-semibold">{{ __('Subscription Status') }}</h4>
                <p class="text-lg text-slate-800 font-semibold">{{ auth()->user()->hasSubscription()? __('Subscribed'): __('Not Subscribed') }}</p>
            </div>
        </div>
    </x-card>
</x-account-layout>
