@props(['disabled' => false, 'value' => ''])

<textarea
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm']) !!}
>{!! $value !!}</textarea>
<!-- Order your soul. Reduce your wants. - Augustine -->
