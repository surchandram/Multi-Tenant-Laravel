<footer class="w-full h-14 flex items-center text-sm bg-white fixed bottom-0 z-40">
    <div>
        <x-link-button
            size="sm"
            is-text
            bold
            variant="teal"
            class="px-4 py-3"
            href="{{ route('home') }}"
        >
            {{ config('app.name') }}
        </x-link-button>
    </div>
</footer>

