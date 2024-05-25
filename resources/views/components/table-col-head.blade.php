@props([
    'dark' => false,
    'withDark' => false,
    'borderless' => true,
    'noBold' => false,
    'centered' => false
])

@php
    $darkMode = !$dark ? 'text-gray-900' : 'text-white';
    $border = $borderless ? '' : 'border border-b-0';
    $bold = $noBold ? '': 'font-medium';
    $centered = $centered ? 'text-center' : 'text-left';

    if($withDark && !$dark) {
        $darkMode = 'dark:text-white text-gray-900';
    }
@endphp

<th {{ $attributes->merge(['scope' => "col", 'class' => "px-6 py-4 whitespace-nowrap text-sm {$centered} {$darkMode} {$border} {$bold}"]) }}>
    {{ $slot }}
</th>
