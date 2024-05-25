<x-dashboard-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('Tickets | Support Center')) }}
    </x-slot>
    
    <div
        x-data="FiltersMap(
            'modal-ticket-filters',
            @js(route('support.tickets.filters.index')),
            @js(\Illuminate\Support\Arr::except(request()->query(), 'page'))
        )"
    >
        <div class="flex items-center justify-between">
            <h4 class="text-lg font-semibold tracking-wider">{{ __('Tickets') }}</h4>

            <div class="btn-group" role="group">
                <x-link-button
                    size="sm"
                    bold
                    light
                    rounded="md"
                    href="{{ route('support.tickets.create') }}"
                >
                    {{ __('New Ticket') }}
                </x-link-button>
            </div>
        </div>
        
        <!-- Filters Modal -->
        <x-filters-modal-form id="modal-ticket-filters" />

        <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>
        
        <!-- Search + Filter Buttons -->
        <div class="w-full flex flex-col md:items-center md:inline-flex md:flex-row gap-4 mb-3">
            <!-- Search -->
            <div class="flex flex-col flex-1 mb-3 md:mb-0">
                <form method="GET" action="">
                    <template x-for="(value, name) in selected">
                        <input type="hidden" x-bind:name="name" x-bind:value="value">
                    </template>

                    <div class="flex items-center gap-2">
                        <x-input
                            type="search"
                            class="flex-1 h-full"
                               name="search"
                               placeholder="{{ __('Search by title, slug...') }}"
                               value="{{ old('search', request('search')) }}"
                               aria-describedby="button-search"
                        />
            
                        <div class="input-group-append">
                            <x-button light size="sm" bold class="primary" type="submit" id="button-search">{{ __('Search') }}</x-button>
                        </div>
                    </div><!-- /.input-group -->
                </form>
            </div>
            
            <!-- Filter Toggle Button -->
            <x-button
                type="button"
                no-margin
                variant="teal"
                size="sm"
                light
                bold
                class="focus:ring"
                tabindex="-1"
                @click.prevent="showFiltersModal"
            >
                {{ __('Filters') }}
            </x-button>
            
            <!-- Filter Clear Button -->
            <x-link-button
                href="{{ route('support.tickets.index') }}"
                no-margin
                variant="slate"
                rounded="md"
                shades="800,800,800"
                size="sm"
                light
                bold
                class="text-center focus:ring"
                tabindex="-1"
                x-show="hasSelectedFilters"
                style="display: none;"
            >
                {{ __('Clear Filters') }}
            </x-link-button>
        </div>

        <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>

        <x-card no-pad no-wrap-pad class="card mb-5">
            <div class="-my-2">
                <x-table responsive>
                    <x-slot name="header">
                        <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Priority') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Status') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Resolved On') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Date Added') }}</x-table-col-head>
                        <x-table-col-head>&nbsp;</x-table-col-head>
                    </x-slot>

                    <!-- tbody -->
                    @foreach($tickets as $ticket)
                        <x-table-row>
                            <x-table-col>
                                <p>{{ $ticket->title }}</p>

                                <div class="mt-4 text-xs font-semibold">
                                    {!! __('Opened via :source', ['source' => "<span class=\"px-2 py-1 rounded-lg bg-blue-500 text-white\">{$ticket->source}</span>"]) !!} 
                                </div>
                            </x-table-col>
                            <x-table-col>{{ $ticket->priority }}</x-table-col>
                            <x-table-col>{{ $ticket->status }}</x-table-col>
                            <x-table-col>{{ optional($ticket->resolved_at)->diffForHumans() }}</x-table-col>
                            <x-table-col>{{ $ticket->created_at->diffForHumans() }}</x-table-col>
                            <x-table-col>
                                <div class="flex items-center gap-2" role="group">
                                    <x-link-button
                                        size="sm"
                                        light
                                        bold
                                        rounded="md"
                                        href="{{ route('support.tickets.show', $ticket) }}"
                                    >
                                        {{ __('View') }}
                                    </x-link-button>

                                    <!-- Ticket Delete Form -->
                                    <form
                                        id="del-ticket-{{ $ticket->id }}-form"
                                        action="{{ route('support.tickets.destroy', $ticket) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')
                                            
                                        <x-link-button
                                            size="sm"
                                            light
                                            bold
                                            rounded="md"
                                            variant="red"
                                            href="{{ route('support.tickets.destroy', $ticket) }}"
                                            onclick="
                                                event.preventDefault();
                                                confirmDelete('del-ticket-{{ $ticket->id }}-form', {{ json_encode($ticket) }});"
                                        >
                                            {{ __('Delete') }}
                                        </x-link-button>
                                    </form>
                                </div>
                            </x-table-col>
                        </x-table-row><!-- /tr -->
                    @endforeach
                </x-table><!-- /table -->
            </div><!-- /table -->
        </x-card><!-- /.card -->

        {{ $tickets->onEachSide(2)->links() }}
    </div>
</x-dashboard-layout>
