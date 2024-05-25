@extends('admin.layouts.default')

@section('title', page_title(__('Ticket Categories')))

@section('content')
    <div>
        <!-- page header -->
        <div class="flex items-center justify-between">
            <h4 class="text-lg font-semibold tracking-wider">{{ __('Ticket Categories') }}</h4>
        
            <div class="flex items-center gap-4" role="group">
                <x-link-button
                    size="sm"
                    bold
                    light
                    rounded="md"
                    href="{{ route('admin.support.tickets.categories.create') }}"
                >
                    {{ __('Add Category') }}
                </x-link-button>
            </div>
        </div>
        
        <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>
        
        <x-card no-pad no-wrap-pad class="card mb-5">
            <div class="-my-2">
                <x-table responsive>
                    <x-slot name="header">
                        <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Status') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Tickets') }}</x-table-col-head>
                        <x-table-col-head>&nbsp;</x-table-col-head>
                    </x-slot>
                
                    <!-- tbody -->
                    @foreach($categories as $category)
                        <x-table-row>
                            <x-table-col-head>
                                {{ $category->name }}
                            </x-table-col>
                            <x-table-col>
                                {{ $category->usable ? __('Active') : __('Disabled') }}
                            </x-table-col>
                            <x-table-col>{{ $category->tickets_count }}</x-table-col>
                            <x-table-col>
                                <div class="flex items-center gap-2" role="group">
                                    <x-link-button
                                        size="sm"
                                        light
                                        bold
                                        rounded="md"
                                        href="{{ route('admin.support.tickets.categories.edit', $category) }}"
                                    >
                                        {{ __('Edit') }}
                                    </x-link-button>
                
                                    <!-- Category Delete Form -->
                                    <form
                                        id="del-category-{{ $category->id }}-form"
                                        action="{{ route('admin.support.tickets.categories.destroy', $category) }}"
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
                                            href="{{ route('admin.support.tickets.categories.destroy', $category) }}"
                                            onclick="
                                                event.preventDefault();
                                                confirmDelete('del-category-{{ $category->id }}-form', {{ json_encode($category) }});"
                                        >
                                            {{ __('Delete') }}
                                        </x-link-button>
                                    </form>
                                </div>
                            </x-table-col>
                        </x-table-row><!-- /tr -->
                    @endforeach
                </x-table><!-- /table -->
            </div>
        </x-card><!-- /.card -->
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, category) {
            // find form
            var form = document.getElementById(id);

            // config
            let config = _.merge(swalCustomConfirmOptions, {
                title: `<small>Are you sure you want to delete <strong>${category.name}</strong> category?</small>`,
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
                        title: `${category.name} category is being deleted.`,
                        type: 'info'
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    FlashMessage.fire(
                        'Delete Action Cancelled',
                        'Your category is safe :)',
                        'info'
                    );
                }
            })
        };
    </script>
@endpush
