<x-app-layout>
    @if (isset($pageTitle))
        <x-slot name="pageTitle">
            {{ $pageTitle }}
        </x-slot>
    @endif

    @if (isset($header))
        <x-slot name="header">
            {{ $header }}
        </x-slot>
    @elseif (isset($title))
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $title }}
            </h2>
        </x-slot>
    @endif

    <section class="py-12 px-4 sm:px-6 lg:px-12">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-48 mb-4 md:mb-0">
                @include('dashboard.layouts.partials._navigation')
            </div>
    
            <div class="w-full md:flex-1">
                {{ $slot }}
            </div>
        </div>
    </section>
</x-app-layout>
