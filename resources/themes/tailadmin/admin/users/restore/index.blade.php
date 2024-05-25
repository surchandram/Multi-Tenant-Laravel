@extends('admin.layouts.default')

@section('title', page_title(__('Deactivated Users')))

@section('content')
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-semibold tracking-wider">{{ __('Deactivated Users') }}</h4>

        <div class="btn-group" role="group">
            <!-- Add some buttons here -->
        </div>
    </div>

    <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>

    <!-- Search -->
    <div class="flex flex-col mb-3">
        <form action="">
            <div class="flex items-center gap-2 mb-3">
                <x-input
                    type="search"
                    class="flex-1 h-full"
                    name="search"
                    placeholder="{{ __('Search user by name, email...') }}"
                    value="{{ old('search', request('search')) }}"
                    aria-describedby="button-search"
                />

                <div class="input-group-append">
                    <x-button light size="sm" no-margin type="submit" id="button-search">{{ __('Search') }}</x-button>
                </div>
            </div><!-- /.input-group -->
        </form>
    </div>

    <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>

    @if($users->count())
        <x-card clear-width no-pad no-wrap-pad class="mb-5">
            <x-slot name="header" class="text-sm font-semibold border-b">
                {{ __('List of deactivated user accounts.') }}
            </x-slot>

            <x-table-responsive responsive class="">
                <x-slot name="header">
                    <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                    <x-table-col-head>{{ __('Email') }}</x-table-col-head>
                    <x-table-col-head>{{ __('Joined') }}</x-table-col-head>
                    <x-table-col-head>{{ __('Deactivated') }}</x-table-col-head>
                    <x-table-col-head>&nbsp;</x-table-col-head>
                </x-slot>

                <!-- tbody -->
                @foreach($users as $user)
                    <x-table-row striped>
                        <x-table-col bold>{{ $user->name }}</x-table-col>
                        <x-table-col>{{ $user->email }}</x-table-col>
                        <x-table-col>{{ $user->created_at->diffForHumans() }}</x-table-col>
                        <x-table-col>{{ optional($user->deleted_at)->diffForHumans() }}</x-table-col>
                        <x-table-col>
                            <div class="flex items-center gap-2" role="group">
                                <!-- User Restore Form -->
                                <form
                                    id="restore-user-{{ $user->id }}-form"
                                    action="{{ route('admin.users.restore.store') }}"
                                    method="POST"
                                >
                                    @csrf

                                    <input type="hidden" name="email" value="{{ $user->email }}" />
                                    
                                    <x-link-button themed
                                        size="sm"
                                        rounded="md"
                                        bg="teal"
                                        light
                                        ring
                                        href="#"
                                        onclick="event.preventDefault();
                                                confirmDelete('restore-user-{{ $user->id }}-form', {{ json_encode($user->name) }});"
                                    >
                                        {{ __('Restore') }}
                                    </x-link-button>
                                </form>
                            </div>
                        </x-table-col>
                    </x-table-row><!-- /tr -->
                @endforeach
            </x-table-responsive><!-- /table -->
        </x-card><!-- /.card -->

        {{ $users->onEachSide(2)->links() }}
    @else
        <p class="text-lg font-slate-400">{{ __('No users to display.') }}</p>
    @endif
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, name) {
            // find form
            var form = document.getElementById(id);

            // config
            let config = _.merge(swalCustomConfirmOptions, {
                title: `<small>Are you sure you want to restore <strong>${name}</strong>?</small>`,
                text: "Make sure the user has requested their account to be restored.",
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
                        title: `${name}'s account is being restored.`,
                        type: 'info'
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    FlashMessage.fire(
                        'User Account Restore Cancelled',
                        'User is safe :)',
                        'info'
                    );
                }
            })
        };
    </script>
@endpush
