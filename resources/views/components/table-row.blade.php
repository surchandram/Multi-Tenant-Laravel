@props([
    'dark' => false,
    'withDark' => false,
    'borderless' => false,
    'striped' => false,
    'noHover' => false
])

@php
    $darkMode = $dark ? 'bg-slate-800' : 'bg-white';
    $hoverState = $noHover ? '' : ('transition duration-300 ease-in-out' . ($dark ? ' hover:bg-slate-700' : ' hover:bg-gray-100'));
    $border = $borderless ? '' : 'border-b';
    $stripes = $striped ? ($dark ? 'odd:bg-slate-800 even:bg-slate-800/20' : 'odd:bg-gray-100 even:bg-white')  : '';

    if($withDark && !$dark) {
        $darkMode = 'dark:bg-slate-800 bg-white';
        $hoverState = 'transition duration-300 ease-in-out dark:hover:bg-slate-700 hover:bg-gray-100';
        $stripes = 'dark:odd:bg-slate-800 dark:even:bg-slate-800/20 odd:bg-gray-100 even:bg-white';
    }
@endphp

<tr {{ $attributes->merge(['class' => "{$darkMode} {$border} {$stripes} {$hoverState}"]) }}>
    {{ $slot }}
</tr>
