@props([
    'route' => null,
])
<li>
    <a class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
        href="{{ (empty($route)) ? '#' : route($route) }}" :class="@js(request()->routeIs($route)) && '!text-white'">
        @if (isset($icon))
            {{ $icon }}
        @endif
        {{ $slot }}
    </a>
</li>
