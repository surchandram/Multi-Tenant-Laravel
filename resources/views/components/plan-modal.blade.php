@props([
    'name',
    'plan'
])

<x-modal :name="$name">
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between px-6 py-2 border-b">
            <h4 class="text-lg font-semibold tracking-wider">
                {{ $plan->name }} ({{ $plan->formatted_price }})
            </h4>

            <x-button
                type="button"
                class="close"
                is-text
                variant="gray"
                rounded="md"
                data-dismiss="modal"
                aria-label="Close"
                @click.prevent="$dispatch('close-modal', 'plan_{{ $plan->id }}_modal')"
            >
                <span aria-hidden="true">&times;</span>
            </x-button>
        </div><!-- /.modal-header -->

        <div class="p-6">
            <h5 class="text-sm font-semibold">{{ __('Features') }}</h5>

            <div class="w-full py-2"></div>

            <ul class="list-unstyled">
                @foreach($plan->features as $feature)
                    <li class="py-2">
                        <strong>{{ $feature->limit }}</strong>
                        {{ $feature->feature->name }}
                    </li>
                @endforeach
            </ul>
        </div><!-- /.modal-body -->

        <div class="flex items-center justify-end px-6 py-2 border-t border-gray-300">
            <x-secondary-button
                x-data=""
                type="button"
                class=""
                data-dismiss="modal"
                @click.prevent="$dispatch('close-modal', 'plan_{{ $plan->id }}_modal')"
            >
                {{ __('Close') }}
            </x-secondary-button>
        </div><!-- /.modal-footer -->
    </div>
</x-modal>
