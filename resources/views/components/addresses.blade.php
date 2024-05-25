@props([
	'addresses',
    'routeParams' => null,
    'creatorRoute' => 'account.addresses.create',
    'updateRoute' => 'account.addresses.update'
])

<x-card no-pad>
    <x-slot name="header" class="flex items-center border-b">
        <h4 class="text-lg font-semibold mr-auto">{{ __('Addresses') }}</h4>

        <x-link-button
            light
            rounded="md"
            size="sm"
            href="{{ route($creatorRoute, $routeParams) }}"
        >
            {{ __('Add new address') }}
        </x-link-button>
    </x-slot>

    <div class="flex flex-col divide-y divide-gray-300">
        @forelse ($addresses as $address)
            <x-address
                :address="$address"
                :update-route="$updateRoute"
                :route-params="$routeParams"
            />
        @empty
            <div class="px-6 py-2">
                <p class="text-sm text-slate-600">
                    {{ __('No address found.') }}
                </p>
            </div>
        @endforelse
    </div>
</x-card>
