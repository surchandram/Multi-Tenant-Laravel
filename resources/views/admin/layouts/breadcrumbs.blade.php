<!-- Breadcrumb -->
<ol class="hidden md:flex md:items-center px-6 gap-2 border-b border-gray-300 bg-white">
    <li class="inline-flex items-center breadcrumb-item">
        <x-link-button no-pad is-text size="sm" class="px-2 py-3" href="{{ route('home') }}">{{ config('app.name') }}</x-link-button>
    </li>

    <li class="inline-flex items-center breadcrumb-item{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}">
        <x-link-button no-pad is-text size="sm" class="px-2 py-3" href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</x-link-button>
    </li>

    @foreach(request()->adminBreadcrumbs()->segments() as $key => $segment)
        @if ($loop->last || ($segment['exists'] === false))
            <li class="py-3 text-sm breadcrumb-item @if($loop->last) active @endif">
                <span class="px-2">{{ \Illuminate\Support\Str::title($key) }}</span>
            </li>
        @else
            <li class="py-3 text-sm breadcrumb-item">
                <x-link-button
                    no-pad
                    is-text
                    size="sm"
                    class="px-2 py-3"
                    href="{{ $segment['url'] }}"
                >
                    {{ \Illuminate\Support\Str::title($key) }}
                </x-link-button>
            </li>
        @endif
    @endforeach

    {{-- more items --}}
    @yield('breadcrumb')

    <!-- Breadcrumb Menu-->
    <li class="flex items-center gap-4 ml-auto breadcrumb-menu">
        <div class="btn-group" role="group" aria-label="Button group">
            <a class="btn" href="{{ route('admin.dashboard') }}">
                <i class="icon-graph"></i> &nbsp;{{ __('Dashboard') }}
            </a>

            @yield('breadcrumb-menu')
        </div>
    </li>
</ol>
