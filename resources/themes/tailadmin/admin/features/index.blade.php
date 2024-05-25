@extends('admin.layouts.default')

@section('title', page_title(__('Features')))

@section('content')
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-semibold tracking-wider">{{ __('Features') }}</h4>

        <div class="btn-group" role="group">
            <x-link-button themed light size="sm" bold rounded="md" ring href="{{ route('admin.features.create') }}"
                class="btn btn-primary">
                {{ __('Add a feature') }}
            </x-link-button>
        </div>
    </div>

    <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>

    @if (count($features))
        <x-card clear-width no-pad no-wrap-pad class="mb-5">
            <x-table-responsive>
                <x-slot name="header">
                    <tr>
                        <x-table-col-head>  {{ __('Name') }}
                        </x-table-col-head>
                        <x-table-col-head>  {{ __('Key') }}
                        </x-table-col-head>
                        <x-table-col-head>  {{ __('Status') }}
                        </x-table-col-head>
                        <x-table-col-head>  &nbsp;
                        </x-table-col-head>
                    </tr>
                </x-slot><!-- /thead -->
                <!-- tbody -->
                @foreach ($features as $feature)
                    <x-table-row striped>
                        <x-table-col>
                            {{ $feature->name }}
                        </x-table-col>
                        <x-table-col>
                            {{ $feature->key }}
                        </x-table-col>
                        <x-table-col>
                            {{ $feature->usable ? 'Active' : 'Disabled' }}
                        </x-table-col>
                        <x-table-col>
                            <div class="flex items-center gap-2" role="group">
                                <x-link-button themed light size="sm" bold rounded="md" ring
                                    href="{{ route('admin.features.edit', $feature) }}"
                                    bg="teal"
                                >
                                    {{ __('Edit') }}
                                </x-link-button>
                                <x-link-button themed light size="sm" bold rounded="md" ring
                                    href="{{ route('admin.features.destroy', $feature) }}"
                                    bg="bg-danger"
                                    onclick="
                                    event.preventDefault();
                                    confirmDelete(
                                        'del-plan-feature-{{ $feature->id }}-form',
                                        {{ json_encode($feature) }}
                                    );
                                ">
                                    {{ __('Delete') }}
                                </x-link-button>

                                <!-- Plan Feature Delete Form -->
                                <form id="del-plan-feature-{{ $feature->id }}-form"
                                    action="{{ route('admin.features.destroy', $feature) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </x-table-col>
                    </x-table-row><!-- /tr -->
                @endforeach
            </x-table-responsive>
        </x-card><!-- /.card -->
    @else
        <p class="text-lg font-slate-400">{{ __('No features to display.') }}</p>
    @endif
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, feature) {
            // find form
            var form = document.getElementById(id);

            // config
            let config = _.merge(swalCustomConfirmOptions, {
                title: `<small>Are you sure you want to delete <strong>${feature.name}</strong> from features?</small>`,
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
                        title: `${feature.name} feature is being deleted.`,
                        type: 'info'
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    FlashMessage.fire(
                        'Delete Action Cancelled',
                        'Your feature is safe :)',
                        'info'
                    );
                }
            })
        };
    </script>
@endpush
