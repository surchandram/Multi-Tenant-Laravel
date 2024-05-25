@extends('admin.layouts.default')

@section('title', page_title(__('Homepage Features')))

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h4>{{ __('Homepage Features') }}</h4>

            <p class="text-sm text-slate-800">{{ __('A list of features in homepage features section.') }}</p>
        </div>

        <div class="btn-group" role="group">
            <a href="{{ route('admin.site.features.create') }}" class="btn btn-primary">
                {{ __('Add a feature') }}
            </a>
        </div>
    </div>

    <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>

    @if(count($features))
        <div class="card mb-5">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                    <tr>
                        <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                        <x-table-col-head>{{</x-table-col-head>Slug') }}</x-table-col-head>
                        <x-table-col-head>{{ _</x-table-col-head>atus') }}</x-table-col-head>
                        <x-table-col-head>{{ __('La</x-table-col-head>ited') }}</x-table-col-head>
                        <x-table-col-head>&nbsp;</x-table-col-head>
                    </tr>
                    </thead><!-- /thead -->
                    <tbody>
                    @foreach($features as $feature)
                        <tr>
                            <td>{{ $feature['name'] }}</td>
                            <td>{{ $feature['slug'] }}</td>
                            <td>{{ $feature['usable'] ? 'Active' : 'Disabled' }}</td>
                            <td>{{ optional(\Carbon\Carbon::make($feature['edited_at']))->diffForHumans() }}</td>
                            <td>
                                <div class="flex items-center gap-2" role="group">
                                    <a href="{{ route('admin.site.features.edit', $feature['slug']) }}"
                                       class="btn btn-ghost-info">
                                        {{ __('Edit') }}
                                    </a>
                                    <a href="{{ route('admin.site.features.destroy', $feature['slug']) }}"
                                       class="btn btn-danger"
                                       onclick="event.preventDefault();
                                               confirmDelete('del-plan-feature-{{ $feature['slug'] }}-form', {{ json_encode($feature) }});">
                                        {{ __('Delete') }}
                                    </a>

                                    <!-- Plan Feature Delete Form -->
                                    <form id="del-plan-feature-{{ $feature['slug'] }}-form"
                                          action="{{ route('admin.site.features.destroy', $feature['slug']) }}"
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr><!-- /tr -->
                    @endforeach
                    </tbody><!-- /tbody -->
                </table><!-- /table -->
            </div><!-- /.table-responsive -->
        </div><!-- /.card -->
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
                title: `<small>Are you sure you want to delete <strong>${feature.name}</strong> feature?</small>`,
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
