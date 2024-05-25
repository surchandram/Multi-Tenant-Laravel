<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')Admin &bull; {{ config('app.name', 'Laravel SaaS') }} @yield('titleDesc')</title>

<!-- Fonts -->
{{--<link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

<!-- Admin Styles -->
<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@yield('styles')
