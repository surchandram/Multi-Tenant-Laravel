<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.dashboard'), ' active') }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> {{ __('Dashboard') }}
                </a>
            </li><!-- /.nav-item -->

            <!-- Features -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-diamond"></i> {{ __('Features') }}
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.features.create'), ' active') }}"
                           href="{{ route('admin.features.create') }}">
                            <i class="nav-icon icon-plus"></i> {{ __('Add Feature') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.features.index'), ' active') }}"
                           href="{{ route('admin.features.index') }}">
                            <i class="nav-icon icon-diamond"></i> {{ __('Features') }}
                        </a>
                    </li>
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Plans -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-credit-card"></i> {{ __('Plans') }}
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.plans.create'), ' active') }}"
                           href="{{ route('admin.plans.create') }}">
                            <i class="nav-icon icon-plus"></i> {{ __('Add Plan') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.plans.index'), ' active') }}"
                           href="{{ route('admin.plans.index') }}">
                            <i class="nav-icon icon-credit-card"></i> {{ __('Plans') }}
                        </a>
                    </li>
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Users -->
            <li class="nav-title">{{ __('USERS & ACCESS CONTROL') }}</li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-people"></i> {{ __('Users') }}
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.users.create'), ' active') }}"
                           href="{{ route('admin.users.create') }}">
                            <i class="nav-icon icon-plus"></i> {{ __('Add User') }}
                        </a>
                    </li>

                    <!-- Impersonate User -->
                    {{--@role('admin-root')--}}
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.users.impersonate.index'), ' active') }}"
                           href="{{ route('admin.users.impersonate.index') }}">
                            <i class="nav-icon icon-user"></i> {{ __('Impersonate User') }}
                        </a>
                    </li>
                    {{--@endrole--}}

                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.users.index'), ' active') }}"
                           href="{{ route('admin.users.index') }}">
                            <i class="nav-icon icon-people"></i> {{ __('Users') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.users.restore.index'), ' active') }}"
                           href="{{ route('admin.users.restore.index') }}">
                            <i class="nav-icon icon-exclamation"></i> {{ __('Deactivated Users') }}
                        </a>
                    </li>
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Permissions -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-flag"></i> {{ __('Permissions') }}
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.permissions.create'), ' active') }}"
                           href="{{ route('admin.permissions.create') }}">
                            <i class="nav-icon icon-plus"></i> {{ __('Add Permission') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.permissions.index'), ' active') }}"
                           href="{{ route('admin.permissions.index') }}">
                            <i class="nav-icon icon-flag"></i> {{ __('Permissions') }}
                        </a>
                    </li>
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Roles -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-lock"></i> {{ __('Roles') }}
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.roles.create'), ' active') }}"
                           href="{{ route('admin.roles.create') }}">
                            <i class="nav-icon icon-plus"></i> {{ __('Add Role') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('admin.roles.index'), ' active') }}"
                           href="{{ route('admin.roles.index') }}">
                            <i class="nav-icon icon-lock"></i> {{ __('Roles') }}
                        </a>
                    </li>
                </ul><!-- /.nav-dropdown-items -->
            </li><!-- /.nav-item -->

            <!-- Site -->
            {{-- <li class="nav-title">{{ __('SITE') }}</li> --}}
            <!-- Settings -->
            {{-- <li class="nav-item">
                <a class="nav-link{{ return_if(on_page('admin.settings.index'), ' active') }}"
                   href="{{ route('admin.settings.index') }}">
                    <i class="nav-icon icon-settings"></i> {{ __('Settings') }}
                </a>
            </li><!-- /.nav-item --> --}}
        </ul><!-- /.nav -->
    </nav><!-- /.sidebar-nav -->

    <button class="sidebar-minimizer brand-minimizer" type="button" aria-label="sidebar-minimizer"></button>
</div><!-- /.sidebar -->
