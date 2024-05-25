<x-account-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('API Tokens | Account')) }}
    </x-slot>

    {{-- <h4 class="text-lg font-semibold mb-2">{{ __('API Tokens') }}</h4>

    <p class="text-sm">{{ __('Manage all your API tokens below.') }}</p>

    <div class="w-full my-2 border-t"></div> --}}

    <x-passport-personal-access-tokens></x-passport-personal-access-tokens>
</x-account-layout>
