<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Laravel SaaS Boilerplate is a SaaS template built with Laravel, Bootstrap4 and Vue.Js to enable quick development of subscription based web apps.">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title'){{ config('app.name', 'Laravel SaaS') }}@yield('titleDesc')</title>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@yield('styles')
