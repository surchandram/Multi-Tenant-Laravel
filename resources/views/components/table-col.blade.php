@props([
    'dark' => false,
    'withDark' => false,
    'borderless' => true,
    'bold' => false,
    'noHover' => true
])

@php
    $darkMode = !$dark ? 'text-gray-900' : 'text-white';
    $border = $borderless ? '' : 'border border-b-0';
    $bold = $bold ? 'font-medium' : '';

    if($withDark && !$dark) {
        $darkMode = 'dark:text-white text-gray-900';
    }
@endphp

<td {{ $attributes->merge(['class' => "px-6 py-4 whitespace-nowrap text-sm $darkMode $border $bold"]) }}>
    {{ $slot }}
</td>
