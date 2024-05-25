<x-account-layout>

    <x-slot name="pageTitle">
        {{ page_title(__('Edit Address | Account')) }}
    </x-slot>

    <x-address-editor
        :route="route('account.addresses.update', $address)"
        :countries="$countries"
        :address="$address"
    />
</x-account-layout>
