@props([
    'route' => null,
    'defaultStyles' => "group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4",
    'activeStyles' => "bg-graydark dark:bg-meta-4",
])

@php
    $link = '';
    if (!request()->routeIs($route)) {
        $activeStyles = '';
    }

    if (!$attributes->has('href')) {
        $resolvedUrl = empty($route) ? '#' : route($route);
        $link = $resolvedUrl;
    }
@endphp

<li>
    <a {{ $attributes->merge(['class' => "$defaultStyles $activeStyles", 'href' => $link]) }}
    >
        @if (isset($icon))
            {{ $icon }}
        @endif

        {{ $slot }}
    </a>
</li>
