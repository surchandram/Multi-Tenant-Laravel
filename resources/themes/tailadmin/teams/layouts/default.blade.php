@props([
    'team' => $attributes->get('team')
])
<x-app-layout>
    @if (isset($pageTitle))
        <x-slot name="pageTitle">
            {{ $pageTitle }}
        </x-slot>
    @endif

    <x-slot name="alerts">
        <x-alerts class="sm:px-6 lg:px-12" />
    </x-slot>
    
    <!-- Header -->
    <x-slot name="header">
        @if (isset($header))
            {{ $header }}
        @else
            <div class="p-4 md:p-6">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    @if (isset($title))
                        {{ $title }} | {{ $team->name }}
                    @else
                        {{ $team->name }}
                    @endif
                </h2>
            </div>
        @endif
    </x-slot>

    <x-slot name="sidebar">
        @include('teams.layouts.partials._navigation')
    </x-slot>

    <!-- Main -->
    @yield('content')

    @stack('scripts')
</x-app-layout>
