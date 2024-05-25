@extends('admin.layouts.default')

@section('title', page_title(__('Permissions')))

@section('content')
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-semibold tracking-wider">{{ __('Permissions') }}</h4>

        <div class="btn-group" role="group">
            <x-link-button size="sm" bold light rounded="md" href="{{ route('admin.permissions.create') }}">
                {{ __('Add Permission') }}
            </x-link-button>
            <!-- Filter Toggle Button -->
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
                       placeholder="{{ __('Search by name, slug...') }}"
                       value="{{ old('search', request('search')) }}"
                       aria-describedby="button-search"
                />

                <div class="input-group-append">
                    <x-button light size="sm" bold class="primary" type="submit" id="button-search">Search</x-button>
                </div>
            </div><!-- /.input-group -->
        </form>
    </div>

    <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>

    <x-card no-pad no-wrap-pad class="card mb-5">
        <x-table responsive>
            <x-slot name="header">
                <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                <x-table-col-head>{{ __('Type') }}</x-table-col-head>
                <x-table-col-head>{{ __('Status') }}</x-table-col-head>
                <x-table-col-head>&nbsp;</x-table-col-head>
            </x-slot>

            <!-- tbody -->
            @foreach($permissions as $permission)
                <x-table-row>
                    <x-table-col>{{ $permission->name }}</x-table-col>
                    <x-table-col>{{ $permission->type }}</x-table-col>
                    <x-table-col>{{ $permission->usable ? 'Active' : 'Disabled' }}</x-table-col>
                    <x-table-col>
                        <div class="flex items-center gap-2" role="group">
                            <x-link-button
                                size="sm"
                                light
                                bold
                                rounded="md"
                                href="{{ route('admin.permissions.edit', $permission) }}"
                            >
                                {{ __('Edit') }}
                            </x-link-button>

                            <!-- Permission Delete Form -->
                            <form
                                id="del-permission-{{ $permission->id }}-form"
                                action="{{ route('admin.permissions.destroy', $permission) }}"
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
                                    href="{{ route('admin.permissions.destroy', $permission) }}"
                                    onclick="event.preventDefault();
                                            confirmDelete('del-permission-{{ $permission->id }}-form', {{ json_encode($permission) }});"
                                >
                                    {{ __('Delete') }}
                                </x-link-button>
                            </form>
                        </div>
                    </x-table-col>
                </x-table-row><!-- /tr -->
            @endforeach
        </x-table><!-- /table -->
    </x-card><!-- /.card -->

    {{ $permissions->onEachSide(2)->links() }}
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, permission) {
            // find form
            var form = document.getElementById(id);

            // config
            let config = _.merge(swalCustomConfirmOptions, {
                title: `<small>Are you sure you want to delete <strong>${permission.name}</strong> permission?</small>`,
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
                        title: `${permission.name} permission is being deleted.`,
                        type: 'info'
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    FlashMessage.fire(
                        'Delete Action Cancelled',
                        'Your permission is safe :)',
                        'info'
                    );
                }
            })
        };
    </script>
@endpush
