<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__('Add Address | :name - Teams', ['name' => $team->name])) }}
    </x-slot>

    <x-address-creator :route="route('teams.addresses.store', $team)" :countries="$countries" />
</x-team-layout>
