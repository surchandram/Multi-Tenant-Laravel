@props([
    'route' => '',
    'current' => false,
    'label' => null,
    'icon' => ''
])

@php
    $isActive = !empty($route) ? request()->routeIs($route) : $current;
@endphp

<x-link-button
    {{ $attributes }}
    no-pad
    no-margin
    light
    variant="slate"
    shades="700,800,800"
    size="sm"
    class="w-full inline-flex items-center gap-2 px-4 py-3 nav-link{{ return_if(on_page($route), ' active') }}"
    :active="$isActive"
>
    @if (!$label)
        {{ $slot }}
    @else
        <i class="nav-icon text-xl icon-{{ $icon }}"></i> {{ $label }}
    @endif
</x-link-button>