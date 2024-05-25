<div class="w-full flex flex-col">
    @foreach (['success' => 'green', 'info' => 'blue', 'warning' => 'yellow', 'error' => 'red'] as $key => $value)
        <div
            x-data="{{ json_encode(['show' => session()->has($key), 'message' => session()->get($key)]) }}"
            {{ $attributes->merge(['class' => "px-3 sm:px-6 lg:px-8 mb-2"]) }}
            x-show="show"
            style="display: none;"
            x-init="
                document.addEventListener(@js("$key-message"), event => {
                    message = event.detail.message;
                    show = true;
                });
            "
        >
            <div
                x-data=""
                class="
                    w-full
                    flex-1
                    px-4
                    py-2
                    mb-2
                    bg-{{ $value }}-200
                    text-{{ $value }}-500
                    font-semibold
                "
            >
                <div class="flex items-center gap-2">
                    <div class="flex-1 flex flex-col">
                        @foreach ((array)session()->get($key, []) as $message)
                            {!! $message !!}
                        @endforeach
                    </div>
                    <x-button
                        type="button"
                        no-margin
                        is-text
                        :variant="$value"
                        shades="500,600,600"
                        class="focus:ring focus:ring-{{ $value }}-400"
                        @click="show = false"
                    >&times;</x-button>
                </div>
            </div>
        </div>
    @endforeach
</div>
<!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
