@props([
    'place' => 'top',
    'trigger' => 'focus',
    'content' => '',
    'noBg' => true,
    'hover' => false
])

@php
    $placement =
        [
            'top' => 'top',
            'right' => 'right',
            'bottom' => 'bottom',
            'left' => 'left',
        ][$place] ?? 'top';

    $bg = $noBg ? '' : 'text-white
        font-medium
        text-xs
        leading-tight
        uppercase
        hover:bg-blue-700
        focus:bg-blue-700
        active:bg-blue-800
        hover:rounded
        hover:shadow-lg
        focus:shadow-lg
        focus:outline-none
        focus:ring-0
        active:shadow-lg
    ';

    $trigger = !$hover ? $trigger : 'hover';
@endphp

<div {{ $attributes->merge(['class' => "
            {$bg}
            transition
            duration-150
            ease-in-out
        ",
    'data-bs-toggle' => "popover",
    'data-bs-trigger' => "$trigger",
    'data-bs-placement' => "$placement",
    'data-bs-content' => $content ? $content : '-']) }}"
>
    {{ $slot }}
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var popoverTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="popover"]')
            );

            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new Popover(popoverTriggerEl);
            });
        });
    </script>
@endpush
