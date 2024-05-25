@props(['active' => false])

<x-link-button {{ $attributes }} size="sm" is-text="outline" rounded="sm" light="hover" :active="$active">
    {{ $slot }}
</x-link-button>
