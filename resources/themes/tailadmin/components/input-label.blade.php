@props([
    'value' => null
])

<label class="mb-3 block text-sm font-medium text-black dark:text-white" {{ $attributes }}>{{ $value ?? $slot }}</label>
