@props([
    'webApps' => [],
])

<div class="mr-3">
    <x-dropdown
        align="right"
        width="w-full md:w-96"
        height="md:h-96 md:max-h-96 overflow-hidden"
        content-classes="h-full py-1 bg-white overflow-y-scroll"
    >
        <x-slot name="trigger">
            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                <div>{{ __('Apps') }}</div>

                <div class="ml-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </x-slot>

        <x-slot name="content">
            <div class="w-full mt-0">
                <div class="px-6 lg:px-8 py-2 text-sm text-slate-700 font-semibold">
                    {{ __('Available Apps') }}
                </div>
                
                <!-- Apps -->
                <div class="px-6 lg:px-8 py-5">
                    <div class="grid md:grid-cols-3 gap-6">
                        @foreach($webApps as $app)
                            <x-apps-menu-dropdown-link
                                :href="route('apps.show', $app)"
                                :app="$app"
                            >
                                <div class="w-full h-10 text-center">
                                    {{ $app->name }}
                                </div>
                            </x-apps-menu-dropdown-link>
                        @endforeach
                    </div>
                </div>
            </div>
        </x-slot>
    </x-dropdown>
</div>
