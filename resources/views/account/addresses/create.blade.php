<x-account-layout>

    <x-slot name="pageTitle">
        {{ page_title(__('Add Address | Account')) }}
    </x-slot>

    <x-address-creator :route="route('account.addresses.store')" :countries="$countries" />
</x-account-layout>
