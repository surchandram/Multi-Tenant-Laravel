@php
    $stateVariant = $isText === 'outline' ? 'bg' : $variantType;
@endphp

<button {{ $attributes->merge(['type' => "{$type}", 'class' => "{$padding} {$bold} {$margin} text-{$size} {$textVariant} {$bgVariant} hover:{$stateVariant}-{$variant}-{$shades[1]} focus:{$stateVariant}-{$variant}-{$shades[2]} {$border} focus:outline-none transition ease-in-out duration-100 rounded-{$rounded} disabled:opacity-25 {$conditionalClasses}" ]) }}>
    {{ $slot }}
</button>
