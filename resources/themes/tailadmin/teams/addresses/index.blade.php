<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__('Addresses | :name - Teams', ['name' => $team->name])) }}
    </x-slot>

    <x-addresses
    	:addresses="$addresses"
    	creator-route="teams.addresses.create"
    	update-route="teams.addresses.update"
    	:route-params="$team"
	/>
</x-team-layout>
