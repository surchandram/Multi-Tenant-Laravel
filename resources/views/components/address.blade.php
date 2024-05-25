@props([
	'address',
    'routeParams' => null,
    'updateRoute' => 'account.addresses.update'
])

@php
    $parentParams = !empty($routeParams) ? $routeParams : [];

    if (!is_array($parentParams)) {
        $parentParams = [$parentParams];
    }
@endphp

<div class="px-6 py-4">
    <p class="text-lg text-slate-800 font-semibold mb-2">{{ $address->name }}</p>
    
    <p class="text-sm text-slate-800 font-semibold mb-2">{{ $address->address_1 }}</p>
    
    <p class="text-sm text-slate-800 font-semibold mb-2">
        {{ $address->city }}, {{ $address->postal_code }}
    </p>
    
    <p class="mb-2 text-sm text-slate-800 font-semibold">
        {{ $address->country->name }}
    </p>

    <div class="flex items-center gap-4 mt-4">
        @if (!$address->isDefault())
            <form
                method="POST"
                action="{{ route($updateRoute, array_merge($parentParams, [$address])) }}"
            >
                @csrf
                @method('PATCH')

                <input type="hidden" name="default" value="1" />

                <x-button
                    type="submit"
                    light
                    size="sm"
                    bold
                    class="focus:ring"
                >
                    {{ __('Set as default') }}
                </x-button>
            </form>
        @else
            <div
            	class="
	                px-4
	                py-2
	                rounded-md
	                text-sm
	                text-white
	                font-semibold
	                bg-blue-600
            	"
            >
                {{ __('Primary') }}
            </div>
        @endif

        @if (!$address->forBilling())
            <form
                method="POST"
                action="{{ route($updateRoute, array_merge($parentParams, [$address])) }}"
            >
                @csrf
                @method('PATCH')

                <input type="hidden" name="billing" value="1" />

                <x-button
                    type="submit"
                    variant="teal"
                    light
                    size="sm"
                    bold
                    class="focus:ring"
                >
                    {{ __('Set as billing default') }}
                </x-button>
            </form>
        @else
            <div
            	class="
	                px-4
	                py-2
	                rounded-md
	                text-sm
	                text-white
	                font-semibold
	                bg-teal-600
            	"
            >
                {{ __('Billing default') }}
            </div>
        @endif
    </div>
</div>