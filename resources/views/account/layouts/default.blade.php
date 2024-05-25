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
    @if(isset($header) || isset($title))
        <x-slot name="header">
            @if (isset($header))
                {{ $header }}
            @elseif (isset($title))
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $title }}
                </h2>
            @endif
        </x-slot>
    @endif

    <!-- Main -->
    <div class="flex flex-col md:flex-row gap-4 py-12 px-4 sm:px-6 lg:px-12">
        <div class="w-full md:w-48">
            @include('account.layouts.partials._navigation')
        </div><!-- /.col -->

        <div class="w-full md:w-auto md:flex-1">
            {{ $slot }}
        </div><!-- /.col -->
    </div><!-- /.row -->

    @stack('scripts')
</x-app-layout>
