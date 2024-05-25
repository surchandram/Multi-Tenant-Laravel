@props([
    'href'
])

<li><a class="font-medium" href="{{ $href !== '#' ? route($href) : '#' }}">{{ $slot }} /</a></li>
