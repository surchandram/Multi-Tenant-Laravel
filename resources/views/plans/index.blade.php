<x-simple-layout>
    <x-slot:pageTitle>
        {{ page_title(__('Plans')) }}
    </x-slot>

    <div class="w-full px-6 py-12 bg-blue-600 text-white text-center">
        <div class="container">
            <h1 class="text-2xl font-semibold mb-3">{{ __('Plans') }}</h1>

            <p class="text-lg">{{ __('Choose a pricing plan below that suits your personal needs.') }}</p>
        </div>
    </div>

    <section class="w-full px-4 py-5">
        <div class="grid {{ ($plans->count() < 3) ? 'md:grid-cols-2' : 'md:grid-cols-3' }} gap-4 mb-4">
            @foreach($plans as $plan)
                <x-card no-pad class="w-full text-center">
                    <x-slot name="header">
                        <h4 class="text-lg mb-3">{{ $plan->name }}</h4>

                        <p class="text-xl font-semibold">{{ $plan->formatted_price }}</p>
                    </x-slot><!-- /.card-body -->

                    <ul class="flex flex-col">
                        <li class="px-4 py-2">
                            <h5 class="text-sm font-semibold text-slate-400">{{ __('Features') }}</h5>
                        </li>

                        @foreach($plan->features as $feature)
                            <li class="px-4 py-2 text-sm">
                                {{ $feature->feature->name }} - {{ $feature->limit }}
                            </li><!-- /.list-group-item -->
                        @endforeach
                    </ul><!-- /.list-group -->

                    <div class="p-6">
                        <x-link-button
                            light
                            rounded="md"
                            bold
                            size="lg"
                            href="{{ route('account.subscriptions.index', ['plan' => $plan]) }}"
                            class="w-full text-center"
                        >
                            {{ __('Subscribe') }}
                        </x-link-button>
                    </div><!-- /.card-body -->
                </x-card><!-- /.card -->
            @endforeach
        </div><!-- /.card-deck -->

        <p class="p-6 text-lg text-center text-slate-600 font-semibold">
            {{ __('Not what you want?') }}
            {{ __('See') }} 
            <x-link-button light rounded="md" size="sm" bold variant="teal" class="ml-2" href="{{ route('plans.teams.index') }}">
                {{ __('Team Plans') }}
            </x-link-button>
        </p>
    </section><!-- /section -->
</x-simple-layout>
