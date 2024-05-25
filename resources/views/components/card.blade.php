@props([
    'allowOverflow' => false,
    'noPad' => false,
    'noWrapPad' => false,
    'clearWidth' => false
])

@php
    $padding = $noPad ? '' : 'p-6';
    $wrapperPadding = $noWrapPad ? '' : 'sm:px-6 lg:px-8';
    $width = $clearWidth ? '' : 'max-w-7xl';
@endphp

<div {{ $attributes->merge(['class' => "{$width} mx-auto {$wrapperPadding}"]) }}>
    <div class="bg-white {{ $allowOverflow ? ''  : 'overflow-hidden' }} shadow-sm sm:rounded-lg">
        @if (isset($image))
            {{ $image }}
        @endif

        @if (isset($header))
            <div {{ $header->attributes->merge(['class' => 'px-6 py-4']) }}>{{ $header }}</div>
        @endif

        <div class="{{ $padding }} bg-white border-gray-200">
            {{ $slot }}
        </div>

        @if (isset($footer))
            <div {{ $footer->attributes->merge(['class' => 'px-6 py-4 border-t border-gray-200']) }}>{{ $footer }}</div>
        @endif
    </div>
</div>
