@if (!$toggle)
    <svg {{ $attributes->merge(['class' => "bi {$variant}"]) }} @if(!$variant)stroke="currentColor"@endif @if($size)width="{{ $size }}" height="{{ $size }}"@endif>
        <use xlink:href="{{ asset('images/bootstrap-icons.svg#' . $name) }}"></use>
    </svg>
@else
    <svg {{ $attributes }} class="bi" @if($size)width="{{ $size }}" @if(!$variant)stroke="currentColor"@endif height="{{ $size }}"@endif>
        <use xlink:href="{{ asset('images/bootstrap-icons.svg#' . $name) }}"></use>
    </svg>
@endif
