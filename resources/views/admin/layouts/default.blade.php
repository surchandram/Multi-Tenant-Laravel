<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title'){{ __('Admin') }} &bull; {{ config('app.name', 'SaaS Pro') }} @yield('titleDesc')</title>

    <!-- Admin Styles & Scripts -->
    @vite(['resources/css/main.css', 'resources/css/admin.css', 'resources/js/main.js', 'resources/js/admin.js'])
    @yield('styles')
</head>

<body class="font-sans antialiased">
    <div id="app" class="w-full min-h-screen flex flex-col bg-slate-100 relative">
        <!-- header -->
        @include('admin.layouts.header')

        {{-- app-body --}}
        <div
            x-data="{
                sidebarOpened: false,
                sidebarOpenedMd: false,
                handleDisplay($event) {
                    this.sidebarOpened = $event.detail === true
                },
                handleMdDisplay($event) {
                    this.sidebarOpenedMd = $event.detail === true
                }
            }"
            class="w-full h-full inline-flex py-16"
            x-on:sidebar-is-open.window="handleDisplay($event)"
            x-on:sidebar-is-open-md.window="handleMdDisplay($event)"
            x-on:sidebar-toggle.window="handleDisplay($event)"
            x-on:sidebar-toggle-md.window="handleMdDisplay($event)"
        >
            <!-- sidebar -->
            @include('admin.layouts.sidebar')

            <!-- main content -->
            <main
                class="w-full min-h-screen flex flex-col flex-1 pl-0 pb-16"
                x-bind:class="{ 'md:pl-60': sidebarOpenedMd }"
            >
                @include('admin.layouts.breadcrumbs')

                <div class="px-6 py-4 container-fluid">
                    <div class="animated fadeIn">
                        <x-alerts />

                        @yield('content')
                    </div>
                </div><!-- /.container-fluid -->
            </main><!-- /.main -->

            @include('admin.layouts.aside')
        </div><!-- /.app-body -->

        @include('admin.layouts.footer')
    </div><!-- /#app -->

    <!-- Scripts  -->
    @include('admin.layouts.scripts')
</body>

</html>
