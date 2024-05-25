<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('admin.layouts.partials._head')
    </head>
    <body class="app header-fixed sidebar-md-show sidebar-fixed aside-menu-hidden aside-menu-fixed footer-fixed">
        <div id="app">
            <!-- header -->
            @include('admin.layouts.partials._header')

            <div class="app-body">
                <!-- sidebar -->
                @include('admin.layouts.partials._sidebar')

                <!-- main content -->
                <main class="main">
                    @include('admin.layouts.partials._breadcrumbs')

                    <div class="container-fluid">
                        <div class="animated fadeIn">
                            @include('layouts.partials.alerts._alerts')

                            @yield('content')
                        </div>
                    </div><!-- /.container-fluid -->
                </main><!-- /.main -->

                @include('admin.layouts.partials._aside')
            </div><!-- /.app-body -->

            @include('admin.layouts.partials._footer')
        </div><!-- /#app -->

        <!-- Scripts  -->
        @include('admin.layouts.partials._scripts')
    </body>
</html>
