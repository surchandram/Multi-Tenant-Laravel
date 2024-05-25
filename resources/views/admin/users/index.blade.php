@extends('admin.layouts.default')

@section('title', page_title(__('Users')))

@section('content')
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-semibold tracking-wider">{{ __('Users') }}</h4>

        <div class="btn-group" role="group">
            <x-link-button size="sm" light rounded="md" href="{{ route('admin.users.create') }}">
                {{ __('Add a user') }}
            </x-link-button>
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
            <x-table responsive class="-py-2">
                <x-slot name="header">
                    <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                    <x-table-col-head>{{ __('Email') }}</x-table-col-head>
                    <x-table-col-head>{{ __('Verified') }}</x-table-col-head>
                    <x-table-col-head>{{ __('Joined') }}</x-table-col-head>
                    <x-table-col-head>&nbsp;</x-table-col-head>
                </x-slot>

                <!-- tbody -->
                @foreach($users as $user)
                    <x-table-row striped>
                        <x-table-col>{{ $user->name }}</x-table-col>
                        <x-table-col>{{ $user->email }}</x-table-col>
                        <x-table-col class="{{ return_if($user->hasVerifiedEmail(), 'text-success') ?? 'text-warning' }}">
                            {{ $user->hasVerifiedEmail() ? 'Verified' : 'Not verified' }}
                        </x-table-col>
                        <x-table-col>{{ $user->created_at->diffForHumans() }}</x-table-col>
                        <x-table-col>
                            <div class="flex items-center gap-2" role="group">
                                <x-link-button size="sm" light rounded="md" href="{{ route('admin.users.edit', $user) }}"
                                    class="">
                                    {{ __('Edit') }}
                                </x-link-button>

                                <!-- User deactivation -->
                                <!-- User Delete Form -->
                                <form id="del-user-{{ $user->id }}-form"
                                    action="{{ route('admin.users.destroy', $user) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-link-button size="sm" light rounded="md" href="{{ route('admin.users.destroy', $user) }}"
                                        variant="red"
                                        onclick="event.preventDefault();
                                                confirmDelete('del-user-{{ $user->id }}-form', {{ json_encode($user->name) }});">
                                        {{ __('Deactivate') }}
                                    </x-link-button>    
                                </form>
                            </div>
                        </x-table-col>
                    </x-table-row><!-- /tr -->
                @endforeach
            </x-table><!-- /table -->
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
                title: `<small>Are you sure you want to deactivate <strong>${name}</strong>?</small>`,
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
                        title: `${name}'s account is being deactivated.`,
                        type: 'info'
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    FlashMessage.fire(
                        'User Deactivation Cancelled',
                        'User is safe :)',
                        'info'
                    );
                }
            })
        };
    </script>
@endpush
