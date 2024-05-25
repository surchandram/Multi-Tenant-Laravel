@props([
    'href' => '#',
    'app',
])

@php
    $logo = $app->getFirstMedia('logo');
@endphp

<a
    href="{{ $href }}"
    class="
        overflow-hidden
        text-slate-800
        hover:bg-indigo-100
        focus:outline-none
        focus:bg-indigo-100
        transition
        duration-150
        ease-in-out
    "
>
    <div
        class="
            flex
            flex-col
            items-center
            justify-between
            gap-4
            p-2
        "
    >
        @if($app->hasMedia('logo'))
            <div class="w-20 h-20">
                {{ $logo('thumbnail') }}
            </div>
        @else
            <x-application-mark class="w-20 h-20" />
        @endif
        
        <!-- app name -->
        <h4 class="mt-4 py-2 text-sm font-semibold text-center">
            {{ $slot }}
        </h4>
    </div>
</a>
