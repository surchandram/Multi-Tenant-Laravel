@php
    $stateVariant = $isText === 'outline' ? 'bg' : $variantType;
@endphp
<a {{ $attributes->merge(['class' => "{$padding} {$bold} {$margin} {$uppercase} text-{$size} {$textVariant} {$bgVariant} hover:{$stateVariant}-{$variant}-{$shades[1]} focus:{$stateVariant}-{$variant}-{$shades[2]} {$border} {$outline} {$rounded} {$ring} transition ease-in-out duration-100 {$conditionalClasses}" ]) }}>
    {{ $slot }}
</a>
