<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </x-button>

    <a class="navbar-brand d-sm-down-none" href="{{ route('home') }}">{{ config('app.name') }}</a>

    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </x-button>

    <!-- left -->
    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
    </ul>

    <!-- right -->
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item px-3 d-md-down-none">
            <a class="nav-link" href="{{ route('home') }}">Home</a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
               aria-haspopup="true" aria-expanded="false">
                <img src="{{ auth()->user()->avatar() }}" class="img-avatar" alt="{{ auth()->user()->name }}">
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('dashboard') }}">
                    <i class="icon-speedometer"></i> Your Dashboard
                </a>

                <a class="dropdown-item" href="{{ route('account.index') }}">
                    <i class="icon-user"></i> Your Account
                </a>

                <div class="divider"></div>

                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="icon-logout"></i> Logout
                </a>

                @include('layouts.partials.forms._logout')
            </div>
        </li>
    </ul>

    <button class="navbar-toggler aside-menu-toggler" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
    </x-button>
</header>
