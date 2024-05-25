<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel SaaS') }}
        </a>
        <button class="navbar-toggler" type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @notsubscribed
                <li class="nav-item">
                    <a class="nav-link{{ return_if(on_page('plans.index'), ' active') }}"
                       href="{{ route('plans.index') }}">
                        {{ __('Plans') }}
                    </a>
                </li>
                @endnotsubscribed
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('dashboard'), ' active') }}"
                           href="{{ route('dashboard') }}">
                            {{ __('Dashboard') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('teams.index'), ' active') }}"
                           href="{{ route('teams.index') }}">
                            {{ __('Teams') }}
                        </a>
                    </li>

                    @impersonating
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.users.impersonate.destroy') }}"
                           onclick="event.preventDefault(); document.getElementById('impersonate-stop-form').submit();">
                            {{ __('Stop Impersonating') }}
                        </a>
                    </li>
                    @endimpersonating

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                           role="button"
                           data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false"
                           v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('account.index') }}">
                                {{ __('My Account') }}
                            </a>

                            @can('browse admin')
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    {{ __('Admin Dashboard') }}
                                </a>
                            @endcan

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item"
                               href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            @include('layouts.partials.forms._logout')
                            @include('layouts.partials.forms._impersonate')
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
