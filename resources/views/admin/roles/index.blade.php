@extends('admin.layouts.default')

@section('title', page_title(__('Roles')))

@section('content')
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-semibold tracking-wider">{{ __('Roles') }}</h4>

        <div class="btn-group" role="group">
            <x-link-button size="sm" bold light rounded="md" href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                {{ __('Add a role') }}
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
                       placeholder="{{ __('Search by name, slug...') }}"
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

    <x-card no-pad no-wrap-pad class="mb-5">
        <x-table responsive>
            <x-slot name="header">
                <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                <x-table-col-head>{{ __('Group') }}</x-table-col-head>
                <x-table-col-head>{{ __('Type') }}</x-table-col-head>
                <x-table-col-head>{{ __('Status') }}</x-table-col-head>
                <x-table-col-head>{{ __('Users') }}</x-table-col-head>
                <x-table-col-head>&nbsp;</x-table-col-head>
            </x-slot>

            <!-- tbody -->
            @foreach($roles as $role)
                <x-table-row  striped>
                    <x-table-col-head>
                        <x-popover
                            hover
                            class="inline-block"
                            content="{{ !empty($role->description) ? $role->description : 'No description provided.' }}"
                        >
                            {!! str_repeat('&nbsp;&nbsp;', $role->depth) !!}{{ $role->name }}
                        </x-popover>
                    </x-table-col-head>
                    <x-table-col>{{ optional($role->parent)->name }}</x-table-col>
                    <x-table-col-head>{{ $role->type }}</x-table-col-head>
                    <x-table-col>{{ $role->parent ? $role->usable ? 'Active' : 'Disabled' : '' }}</x-table-col>
                    <x-table-col>
                        <x-popover hover :content="__('Assigned Users')" class="inline-block">
                            {{ $role->usable ? $role->users_count : '' }}
                        </x-popover>
                    </x-table-col>
                    <x-table-col>
                        <div class="flex items-center gap-2" role="group">
                            <x-link-button
                                size="sm"
                                bold
                                light
                                rounded="md"
                                href="{{ route('admin.roles.edit', $role) }}"
                            >
                                {{ __('Edit') }}
                            </x-link-button>

                            <!-- Role Delete Form -->
                            <form
                                id="del-role-{{ $role->id }}-form"
                                action="{{ route('admin.roles.destroy', $role) }}"
                                method="POST"
                            >
                                    @csrf
                                    @method('DELETE')
                                    
                                <x-link-button
                                    size="sm"
                                    bold
                                    light
                                    rounded="md"
                                    variant="red"
                                    href="{{ route('admin.roles.destroy', $role) }}"
                                    onclick="
                                        event.preventDefault();
                                        confirmDelete('del-role-{{ $role->id }}-form', {{ json_encode($role) }});
                                    "
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
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, role) {
            // find form
            var form = document.getElementById(id);

            // config
            let config = _.merge(swalCustomConfirmOptions, {
                title: `<small>Are you sure you want to delete <strong>${role.name}</strong> role?</small>`,
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
                        title: `${role.name} role is being deleted.`,
                        type: 'info'
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    FlashMessage.fire(
                        'Delete Action Cancelled',
                        'Your role is safe :)',
                        'info'
                    );
                }
            })
        };
    </script>
@endpush
