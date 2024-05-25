
<x-dashboard-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('#:ticket | Tickets | Support Center', ['ticket' => $ticket->id])) }}
    </x-slot>
    
    <div class="pb-6">
        <x-card no-wrap-pad class="card mb-5">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-semibold mb-2">
                        {{ __('Ticket #:ticket', ['ticket' => $ticket->id]) }}
                    </h2>

                    <h4 class="text-lg font-semibold mb-2">{{ $ticket->title }}</h4>
                    
                    <!-- Owner -->
                    <p class="mt-4 text-sm text-slate-600">
                        <span class="font-semibold">{{ ('Opened by:') }}</span>&nbsp;
                        {{ $ticket->user->name }}
                    </p>
        
                    <!-- Source -->
                    <div class="mt-4 text-xs font-semibold">
                        {!! __('Opened via :source', ['source' => "<span class=\"p-2 rounded-lg bg-blue-500 text-white\">{$ticket->source}</span>"]) !!} 
                    </div>
        
                    <!-- Agent -->                
                    <p class="mt-4 text-sm text-slate-600">
                        <span class="font-semibold">{{ ('Agent:') }}</span>
                        {{ $ticket->agent ? $ticket->agent->name : __('No agent assigned.') }}
                    </p>
                </div>
        
                <div class="text-sm text-slate-600">
                    <span class="font-semibold">{{ __('Opened') }}</span> 
                    <span class="font-semibold">{{ $ticket->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </x-card><!-- /.card -->
        
        <!-- Summary -->
        <x-card no-wrap-pad class="mt-4">
            <x-slot name="header" class="border-b">
                <h4 class="text-lg font-semibold">{{ __('Summary') }}</h4>
            </x-slot>
        
            <p>
                <span class="font-semibold">{{ __('Priority:') }}</span>&nbsp;
                {{ \Illuminate\Support\Str::title($ticket->priority) }}
            </p>

            <p class="mt-4">
                <span class="font-semibold">{{ __('Status:') }}</span>&nbsp;
                {{ \Illuminate\Support\Str::title($ticket->status) }}
            </p>
                
            <p class="mt-4">
                @if ($ticket->resolved_at)
                    {{ __('Resolved :date', ['date' => "{$ticket->resolved_at->diffForHumans()}"]) }}
                @else
                    {{ __('Not yet marked as resolved.') }}
                @endif
            </p>

            <p class="mt-4 font-semibold">
                {{ __('Category:') }}
            </p>

            <div class="flex gap-2 mt-2">
                @forelse ($ticket->categories as $category)
                    <span class="px-2 py-1 mr-2 text-lg rounded bg-teal-600 text-white">
                        {{ $category->name }}
                    </span>
                @empty
                    {{ __('No categories assigned.') }}
                @endforelse
            </div>
        
            <p class="mt-4 font-semibold">
                {{ __('Labels:') }}
            </p>

            <div class="flex flex-wrap gap-2 mt-2">
                @forelse ($ticket->labels as $label)
                    <span class="px-2 py-1 mr-2 text-sm rounded bg-slate-800 text-white">{{ $label->name }}</span>
                @empty
                    {{ __('No labels assigned.') }}
                @endforelse
            </div>
        
            <div class="mt-4">
                <div x-data="" class="flex items-center gap-2" role="group">
                    {{-- <p class="text-lg font-semibold">{{ __('Actions:') }}</p> --}}
        
                    {{-- <x-link-button
                        x-data=""
                        size="sm"
                        light
                        bold
                        rounded="md"
                        href="{{ route('support.tickets.show', $ticket) }}"
                        @click.prevent=""
                    >
                        {{ __('Archive') }}
                    </x-link-button> --}}
        
                    <!-- Ticket Delete Form -->
                    {{-- <form
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
                    </form> --}}
                </div>
            </div>
        </x-card><!-- /tr -->
        
        <!-- Original Message -->
        <x-card no-wrap-pad class="mt-4 first:mt-0">
            <x-slot name="header" class="border-b">
                <div class="flex items-center justify-between">
                    <h4 class="text-lg font-semibold">
                        {{ __('Original message') }}
                    </h4>
                </div>
            </x-slot>
        
            <div>
                {{ $ticket->message }}
            </div>
        </x-card>
        
        <!-- Messages -->
        <section class="mt-5 py-6">
            <h4 class="mb-2 text-lg font-semibold">{{ __('Messages') }}</h4>
        
            @forelse($ticket->messages->groupBy(fn($message) => $message->created_at->format('Y-m-d')) as $date => $grouped)
                <div class="flex flex-col md:flex-row items-start gap-4 mt-4 first:mt-0">
                    <!-- Date -->
                    <div class="w-full md:w-auto flex items-center justify-center py-2 md:mb-auto">
                        <div class="p-2 text-sm font-semibold rounded-md bg-slate-800 text-white">
                            {{ \Illuminate\Support\Carbon::parse($date)->format('Y-m-d') }}
                        </div>
                    </div>
                    
                    <!-- Messages -->
                    <div class="flex flex-col flex-1 gap-4">
                        @foreach($grouped as $message)
                            <div class="w-full">
                                <x-card class="ml-1 mt-4 first:mt-0">
                                    <!-- Sender details -->
                                    <div class="flex items-start justify-between">
                                        <p class="text-sm font-semibold">
                                            @if ($message->user->id === auth()->id())
                                                {{ __('You') }}
                                            @else
                                                {{ $message->user->name }}
                                            @endif
                                        </p>
                                        
                                        <!-- meta -->
                                        <p class="text-sm text-slate-600">
                                            @if ($message->user->id !== auth()->id())
                                                {{ __('Replied ') }}
                                            @endif
                                            <span class="font-semibold">
                                                {{ $message->created_at->diffForHumans() }}
                                            </span>
                                        </p>
                                    </div>
                                                
                                    <div class="mt-4">
                                        {{ $message->body }}
                                    </div>
                                </x-card>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <h4 class="text-lg font-semibold text-slate-600 tracking-wider">
                    {{ __('No messages posted yet.') }}
                </h4>

                <div class="w-full py-4 border-b border-gray-300"></div>
            @endforelse
        
            <!-- Message Form -->
            <div
                class="
                    py-4
                    mt-4
                    {{ $ticket->messages->count() > 0 ? ' ml-28 border-t border-gray-300' : '' }}
                "
            >
                <x-card
                    :no-wrap-pad="$ticket->messages->count() === 0"
                >
                    <!-- Sender details -->
                    <div class="flex items-start justify-between">
                        <x-input-label for="newMessage">
                            {{ __('Your message') }}
                        </x-input-label>
                        
                        <p class="text-sm text-slate-600">
                            <!-- actions -->
                        </p>
                    </div>
                                
                    <div
                        x-data="{
                            body: @js(old('body')),
                            errors: [],
                            processing: false,
                            hasErrors() {
                                return _.size(this.errors) > 0
                            },
                            store() {
                                this.errors = []
                                this.processing = true
                        
                                axios.post(@js(route('support.tickets.messages.store', $ticket)), {
                                    body: this.body
                                }).then((response) => {
                                    this.body = ''
                                    window.location.reload()
                                }).catch(error => {
                                    this.processing = false
                                    if (error.response) {
                                        if (error.response.status === 422) {
                                            this.errors = error.response.data.errors
                                        }
                                    } else if (error.request) {
                                        console.log(error.request);
                                    } else {
                                        console.log('Error', error.message);
                                    }
                                })
                            }
                        }"
                        class="mt-2"
                    >
                        <form method="POST" action="#" x-on:submit.prevent="store">
                            @csrf
                        
                            <div
                                class="px-4 py-2 mb-2 bg-red-500 text-white font-semibold"
                                x-show="hasErrors"
                                style="display: none;"
                            >
                                <template x-for="error in errors">
                                    <template x-for="field in error">
                                        <div class="mt-2 first:mt-0" x-text="field"></div>
                                    </template>
                                </template>
                            </div>
                        
                            <div>
                                <x-textarea
                                    name="body"
                                    id="newMessage"
                                    class="w-full mt-2"
                                    rows="6"
                                    x-model="body"
                                />
                            </div>
                        
                            <div class="flex items-center justify-end mt-4">
                                <x-button type="submit" x-bind:disabled="processing" light bold uppercase size="sm">
                                    {{ __('Send') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                </x-card>
            </div>
        </section>
    </div>
</x-dashboard-layout>
