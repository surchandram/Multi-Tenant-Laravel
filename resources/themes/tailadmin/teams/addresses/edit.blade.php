<x-account-layout>

    <x-slot name="pageTitle">
        {{ page_title(__('Edit Address | :name - Teams', ['name' => $team->name])) }}
    </x-slot>

    <x-address-editor
        :route="route('teams.addresses.update', [$team, $address])"
        :countries="$countries"
        :address="$address"
    />
</x-account-layout>
