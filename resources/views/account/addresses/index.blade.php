<x-account-layout>

    <x-slot name="pageTitle">
        {{ page_title(__('Addresses | Account')) }}
    </x-slot>

    <x-addresses :addresses="$addresses" />
</x-account-layout>
