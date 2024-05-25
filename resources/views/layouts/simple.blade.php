<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@isset($pageTitle){{ $pageTitle }} @endisset{{ config('app.name', 'SaaS Pro') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/main.css', 'resources/js/main.js'])
    </head>
    <body>
        <div class="font-sans text-gray-900 dark:text-white dark:bg-gray-900 antialiased">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center mr-auto">
                                <a href="{{ route('home') }}">
                                    <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="space-x-8 sm:-my-px sm:ml-10 flex items-center mr-auto">
                            </div>
                        </div>

                        <!-- Right Navigation Links -->
                        <div class="sm:-my-px h-full flex items-center gap-4">
                            <!-- Pricing -->
                            <x-nav-link
                                class="h-full"
                                :active="request()->routeIs('plans.index')"
                                :href="route('plans.index')"
                            >
                                {{ __('Plans') }}
                            </x-nav-link>

                            <!-- Apps Dropdown -->
                            <x-apps-menu-dropdown :web-apps="$webApps" />

                            <!-- Support Dropdown -->
                            <div class="mr-3">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                            <div>{{ __('Support') }}</div>

                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link
                                            class="dropdown-item"
                                            :href="route('support.tickets.create')"
                                        >
                                            {{ __('New Ticket') }}
                                        </x-dropdown-link>

                                        <x-dropdown-link :href="route('support.tickets.index')">
                                            {{ __('My Tickets') }}
                                        </x-dropdown-link>

                                        <div class="w-full py-2 border-t border-gray-300"></div>

                                        <h4 class="px-2 mb-2 text-xs font-semibold text-slate-500">
                                            {{ __('More Resources') }}
                                        </h4>

                                        <x-dropdown-link href="#">
                                            {{ __('Documentation') }}
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>

                            <!-- Login links -->
                            @if (Route::has('login'))
                                @auth
                                    <x-nav-link class="h-full" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                        {{ __('Dashboard') }}
                                    </x-nav-link>

                                    @impersonating
                                        <x-nav-link class="h-full" :href="route('admin.users.impersonate.destroy')"
                                            :active="request()->routeIs('admin.users.impersonate.destroy')"
                                            onclick="event.preventDefault(); document.getElementById('impersonate-stop-form').submit();">
                                                {{ __('Stop Impersonating') }}
                                        </x-nav-link>
                                    @endimpersonating
                                @else
                                    <x-nav-link class="h-full" href="{{ route('login') }}">{{ __('Login') }}</x-nav-link>

                                    @if (Route::has('register'))
                                        <x-nav-link class="h-full" href="{{ route('register') }}">{{ __('Register') }}</x-nav-link>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            {{ $slot }}

            <!-- Footer -->
            <footer class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Left Navigation Links -->
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center mr-auto">
                                <p class="text-sm text-slate-600 font-semibold">
                                    &copy; {{ date('Y') }} {{ config('app.name') }}
                                </p>
                            </div>

                            <!-- Navigation Links -->
                            <div class="space-x-8 sm:-my-px sm:ml-10 flex items-center mr-auto">
                                <!-- more links here -->
                            </div>
                        </div>

                        <!-- Right Navigation Links -->
                        <div class="sm:-my-px h-full flex items-center gap-4">
                            <x-nav-link class="h-full" :href="route('terms.show')">
                                {{ __('Terms of Service') }}
                            </x-nav-link>
                            <x-nav-link class="h-full" :href="route('policy.show')">
                                {{ __('Privacy Policy') }}
                            </x-nav-link>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
