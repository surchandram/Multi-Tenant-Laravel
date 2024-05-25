@props([
    'variant' => 'primary',
    'bordered' => false,
    'rounded' => false,
    'plainText' => false,
    'noPad' => false,
    'label' => false,
    'message' => false,
    'darker' => false,
])

@php
    $style = $bordered ? 'border' : 'bg';
    $shade = $bordered ? '500' : '200';
    $rounded = $rounded ? 'rounded-md' : '';
    $border = $bordered ? '' : 'border-transparent';
    $padding = $noPad ? '' : 'px-4 py-2';
    $shade = $darker ? '700' : $shade; 
    
    $variant = data_get(
        [
            'primary' => "blue",
            'info' => "indigo",
            'success' => "green",
            'error' => "red",
            'warn' => "yellow",
            'warn' => "orange",
        ],
        $variant,
    );
    $style = "{$style}-{$variant}-{$shade}";
    $text = $plainText ? '' : "text-{$variant}-{$shade}";
    $col = !isset($icon) ? 'flex-col' : 'gap-4';
@endphp

<div {{ $attributes->merge(['class' => "flex {$col} {$padding} border-l-4 border $border $style $rounded $text"]) }}>
    @if (isset($icon))
        <div class="flex items-center px-2 py-1 text-center text-white bg-{{ $variant }}-{{ $shade }}">
            {{ $icon }}
        </div>
    @endif

    @if (isset($icon))
        <div class="flex-1">
    @endif
    @if ($label || $message)
        @if ($label)
            <h4 class="text-sm {{ $text }} font-semibold tracking-wider">{{ $label }}</h4>
        @endif

        @if ($message)
            <article>
                <p class="text-sm {{ $text }}">
                    {{ $message }}
                </p>
            </article>
        @endif
    @else
        {{ $slot }}
    @endif
    @if (isset($icon))
        </div>
    @endif
</div>
