@props([
    'hoverable' => false,
    'striped' => false,
    'dark' => false,
    'withDark' => false,
    'responsive' => true,
])

@php
    $darkMode = (($withDark && !$dark) ? 'dark:bg-gray-800 bg-gray-50' : ($dark ? 'dark:bg-gray-800' : 'bg-gray-50'));
@endphp

@if ($responsive)
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        @if (isset($header))
                            <thead class="border-b {{ $darkMode }}">
                                <tr>
                                    {{ $header }}
                                </tr>
                            </thead><!-- /thead -->
                        @endif

                        <tbody>
                            {{ $slot }}
                        </tbody><!-- /tbody -->
                    </table><!-- /table -->
                </div>
            </div>
        </div>
    </div><!-- /.table-responsive -->
@else
    <table class="min-w-full">
        @if (isset($header))
            <thead class="border-b {{ $darkMode }}">
                <tr>
                    {{ $header }}
                </tr>
            </thead class="border-b"><!-- /thead -->
        @endif

        <tbody>
            {{ $slot }}
        </tbody><!-- /tbody -->
    </table>
@endif
