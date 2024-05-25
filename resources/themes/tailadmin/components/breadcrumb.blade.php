<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        {{ $slot }}
    </h2>

    <nav>
        <ol class="flex items-center gap-2">
            @if(isset($items))
                {{ $items }}
            @endif

            @if(isset($active))
                <li class="font-medium text-primary">{{ $active }}</li>
            @endif
        </ol>
    </nav>
</div>
