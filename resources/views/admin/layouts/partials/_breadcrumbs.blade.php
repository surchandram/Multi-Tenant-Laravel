<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">{{ config('app.name') }}</a>
    </li>

    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</a>
    </li>

    {{-- @foreach(request()->breadcrumbs()->segments(1) as $segment)
        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
            @if($loop->last)
                {{ method_exists($segment->model(), 'breadcrumbName') ? optional($segment->model())->breadcrumbName() : $segment->name() }}
            @else
                <a href="{{ $segment->url() }}">
                    {{ method_exists($segment->model(), 'breadcrumbName') ? optional($segment->model())->breadcrumbName() : $segment->name() }}
                </a>
            @endif
        </li>
    @endforeach --}}

    {{-- more items --}}
    @yield('breadcrumb')

    <!-- Breadcrumb Menu-->
    <li class="breadcrumb-menu d-md-down-none">
        <div class="btn-group" role="group" aria-label="Button group">
            <a class="btn" href="{{ route('admin.dashboard') }}">
                <i class="icon-graph"></i> &nbsp;{{ __('Dashboard') }}
            </a>

            @yield('breadcrumb-menu')
        </div>
    </li>
</ol>
