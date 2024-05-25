@extends('admin.layouts.default')

@section('title', page_title(__('#:ticket | Tickets', ['ticket' => $ticket->id])))

@section('content')
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-semibold tracking-wider">{{ __('#:ticket | Tickets', ['ticket' => $ticket->id]) }}</h4>

        <div class="flex items-center gap-2" role="group">
            @if ($ticket->agent_id)
                @if (!$ticket->archived_at)
                    <x-link-button size="sm" bold light rounded="md" href="#">
                        {{ __('Archive') }}
                    </x-link-button>
                @endif

                @if (!$ticket->locked_at)
                    <x-link-button variant="red" size="sm" bold light rounded="md" href="#">
                        {{ __('Lock') }}
                    </x-link-button>
                @endif
            @else
                {{ __('Assign agent first to see available actions.') }}
            @endif
        </div>
    </div>

    <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>

    <x-card no-wrap-pad class="card mb-5">
        <div class="flex items-start justify-between">
            <div>
                <h4 class="text-lg font-semibold mb-2">{{ $ticket->title }}</h4>
                
                <!-- Owner -->
                <p class="mt-4 text-sm text-slate-800">
                    <span class="font-semibold">{{ ('Opened by:') }}</span>&nbsp;
                    {{ $ticket->user->name }}
                </p>

                <!-- Source -->
                <div class="mt-4 text-xs font-semibold">
                    {!! __('Opened via :source', ['source' => "<span class=\"p-2 rounded-lg bg-blue-500 text-white\">{$ticket->source}</span>"]) !!} 
                </div>

                <!-- Agent -->                
                <p class="mt-4 text-sm text-slate-800">
                    <span class="font-semibold">{{ ('Agent:') }}</span> 
                    {{ $ticket->agent ? $ticket->agent->name : __('No agent assigned.') }}
                </p>
            </div>

            <div class="text-sm text-slate-800">
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

        <p class="mt-4">
            <div class="font-semibold">{{ __('Opened:') }}</div>&nbsp;
            {{ $ticket->created_at->diffForHumans() }}
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

        <div class="flex flex-wrap gap-2 mt-2 mb-4">
            @forelse ($ticket->labels as $label)
                <span class="px-2 py-1 mr-2 text-sm rounded bg-slate-800 text-white">
                    {{ $label->name }}
                </span>
            @empty
                {{ __('No labels assigned.') }}
            @endforelse
        </div>

        <div class="mt-4">
            <div x-data="" class="flex items-center gap-2" role="group">
                <p class="text-lg font-semibold">{{ __('Actions:') }}</p>

                @if ($ticket->agent_id)
                    <x-link-button
                        x-data=""
                        size="sm"
                        light
                        bold
                        rounded="md"
                        href="{{ route('admin.support.tickets.show', $ticket) }}"
                        @click.prevent=""
                    >
                        {{ __('Archive') }}
                    </x-link-button>

                    <!-- Ticket Lock -->
                    @if (!$ticket->locked_at)
                        <x-link-button variant="red" size="sm" bold light rounded="md" href="#">
                            {{ __('Lock') }}
                        </x-link-button>
                    @endif

                    <!-- Ticket Delete Form -->
                    {{-- <form
                        id="del-ticket-{{ $ticket->id }}-form"
                        action="{{ route('admin.support.tickets.destroy', $ticket) }}"
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
                            href="{{ route('admin.support.tickets.destroy', $ticket) }}"
                            onclick="
                                event.preventDefault();
                                confirmDelete('del-ticket-{{ $ticket->id }}-form', {{ json_encode($ticket) }});"
                        >
                            {{ __('Delete') }}
                        </x-link-button>
                    </form> --}}
                @else
                    {{ __('Assign agent first to see available actions.') }}
                @endif
            </div>
        </div>
    </x-card><!-- /tr -->

    <!-- Original Message -->
    <x-card no-wrap-pad class="mt-4 first:mt-0">
        <x-slot name="header" class="border-b">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold">
                    {{ __('Original message') }}
                </p>
            </div>
        </x-slot>

        <div>
            {{ $ticket->message }}
        </div>
    </x-card>

    @if ($stillOpen)
        @can ('update', $ticket)
                <x-card no-wrap-pad allow-overflow class="mt-4">
                    <h4 class="mb-2 text-lg font-semibold">{{ __('Update ticket status') }}</h4>

                    <form method="POST" action="{{ route('admin.support.tickets.update', $ticket) }}">
                        @csrf
                        @method('PATCH')

                        <x-validation-errors />

                        <div class="mt-4">
                            <x-input-label for="status" class="mb-2">
                                {{ __('Status') }}
                            </x-input-label>

                            <x-select
                                type="text"
                                name="status"
                                id="status"
                                class="w-full mt-2"
                            >
                                <option value="">{{ __('Set status') }}</option>
                                @foreach (\Saasplayground\SupportTickets\SupportTickets::getStatusMap() as $key => $status)
                                    <option value="{{ $status }}">
                                        {{ \Illuminate\Support\Str::title($status) }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>

                        <div class="flex items-center gap-2 mt-4">
                            <x-checkbox id="lock" name="locked" />
                            <x-input-label for="lock">
                                {{ __('Lock') }} ({{ __('Prevents user from reopening the ticket.') }})
                            </x-input-label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button
                                type="submit"
                                light
                                bold
                                uppercase
                                size="sm"
                            >
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </x-card>
        @endcan
    @endif

    @if (!$ticket->agent_id)
        <x-card no-wrap-pad allow-overflow class="mt-4">
            <h4 class="mb-2 text-lg font-semibold">{{ __('Assign ticket agent') }}</h4>

            <form method="POST" action="{{ route('admin.support.tickets.agents.store', $ticket) }}">
                @csrf

                <div class="mt-4">
                    <x-input-label for="agent_id" class="mb-2">{{ __('Agent') }}</x-input-label>

                    <x-select id="agent_id" name="agent_id" class="w-full mt-2">
                        <option value="">{{ __('Select agent') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-select>

                    <x-input-error :messages="$errors->get('agent_id')" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button type="submit" light size="sm" bold>{{ __('Assign') }}</x-button>
                </div>
            </form>
        </x-card>
    @endif

    <!-- Messages -->
    <section class="mt-5 py-6">
        <h4 class="mb-2 text-lg font-semibold">{{ __('Messages') }}</h4>

        @foreach($ticket->messages->groupBy(fn($message) => $message->created_at->format('Y-m-d')) as $date => $grouped)
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
                                        {{ $message->user->name }}
                                    </p>
                                    
                                    <p class="text-sm text-slate-600">
                                        <!-- actions -->
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
        @endforeach

        <!-- Message Form -->
        @if ($stillOpen)
            @can ('update', $ticket)
                <x-card class="mt-4 ml-28 first:mt-0">
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

                                axios.post(@js(route('admin.support.tickets.messages.store', $ticket)), {
                                    body: this.body
                                }).then((response) => {
                                    this.body = ''
                                    window.location.reload()
                                }).catch(error => {
                                    this.processing = false

                                    if (error.response) {
                                        // The request was made and the server responded with a status code
                                        // that falls out of the range of 2xx
                                        // console.log(error.response.data);
                                        if (error.response.status === 422) {
                                            this.errors = error.response.data.errors
                                        }
                                        console.log(error.response.status);
                                        // console.log(error.response.headers);
                                    } else if (error.request) {
                                        // The request was made but no response was received
                                        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                                        // http.ClientRequest in node.js
                                        console.log(error.request);
                                    } else {
                                        // Something happened in setting up the request that triggered an Error
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
                                    rows="6"
                                    id="newMessage"
                                    class="w-full mt-2"
                                    x-model="body"
                                />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-button
                                    type="submit"
                                    x-bind:disable="processing"
                                    light
                                    bold
                                    uppercase
                                    size="sm"
                                >
                                    {{ __('Send') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                </x-card>
            @else
                {{ __('You need to be the ticket agent to reply or post messages.') }}
            @endcan
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, ticket) {
            // find form
            var form = document.getElementById(id);

            // config
            let config = _.merge(swalCustomConfirmOptions, {
                title: `<small>Are you sure you want to delete <strong>${ticket.title}</strong> ticket?</small>`,
                text: "You won't be able to revert this!",
                type: 'warning',
                animation: false
            });

            // fire sweet alert
            Swal.fire(config).then((result) => {
                if (result.value) {
                    // send request
                    form.submit();

                    // show alert
                    Toast.fire({
                        title: `${ticket.title} ticket is being deleted.`,
                        type: 'info'
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    FlashMessage.fire(
                        'Delete Action Cancelled',
                        'Your ticket is safe :)',
                        'info'
                    );
                }
            })
        };
    </script>
@endpush
