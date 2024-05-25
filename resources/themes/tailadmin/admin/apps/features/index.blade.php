@extends('admin.layouts.default')

@section('title', page_title(__('Manage App Features') . ' - ' . $app->name))

@section('content')
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-semibold tracking-wider">{{ __('App Features') }}</h4>

        <div class="btn-group" role="group">
            <x-link-button themed
                size="sm"
                bold
                light
                rounded="md"
                href="{{ route('admin.apps.features.create', $app) }}"
            >
                {{ __('Add new feature') }}
            </x-link-button>
        </div>
    </div>

    <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>

    <x-card no-pad no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <p class="text-sm font-semibold">
                {!! __('Manage features for app :app.', ['app' => "<strong>{$app->name}</strong>"]) !!}
            </p>
        </x-slot>

        <x-table-responsive responsive>
            <x-slot name="header">
                <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                <x-table-col-head>{{ __('Key') }}</x-table-col-head>
                <x-table-col-head>{{ __('Limit') }}</x-table-col-head>
                <x-table-col-head>{{ __('Default') }}</x-table-col-head>
                <x-table-col-head>&nbsp;</x-table-col-head>
            </x-slot><!-- /thead -->

            @foreach($app->features as $feature)
                <x-table-row>
                    <x-table-col>{{ $feature->feature->name }}</x-table-col>
                    <x-table-col>{{ $feature->feature->key }}</x-table-col>
                    <x-table-col>{{ ($limit = $feature->limit) == 0 ? __('Unlimited') : $limit }}</x-table-col>
                    <x-table-col>{{ $feature->default ? __('Default') : '-' }}</x-table-col>
                    <x-table-col>
                        <div class="flex items-center gap-2" role="group">
                            <x-link-button themed
                                size="xs"
                                bold
                                light
                                rounded="md"
                                href="{{ route('admin.apps.features.edit', [$app, $feature]) }}"
                            >
                                {{ __('Edit') }}
                            </x-link-button>

                            <!-- App Feature Delete Form -->
                            <form id="del-app-feature-{{ $feature->id }}-form"
                                action="{{ route('admin.apps.features.destroy', [$app, $feature]) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <x-link-button themed
                                    size="xs"
                                    bold
                                    light
                                    rounded="md"
                                    href="{{ route('admin.apps.features.destroy', [$app, $feature]) }}"
                                    bg="bg-danger"
                                    onclick="event.preventDefault();
                                            confirmDelete('del-app-feature-{{ $feature->id }}-form', {{ json_encode($feature) }});"
                                >
                                    {{ __('Delete') }}
                                </x-link-button>
                            </form>
                        </div>
                    </x-table-col>
                </x-table-row><!-- /tr -->
            @endforeach
        </x-table-responsive><!-- /table -->
    </x-card><!-- /.card -->
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, feature) {
            // find form
            var form = document.getElementById(id);

            // config
            let config = _.merge(swalCustomConfirmOptions, {
                title: `<small>Are you sure you want to delete <strong>${feature.feature.name}</strong> feature from app?</small>`,
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
                        title: `${feature.feature.name} feature is being deleted from app.`,
                        type: 'info'
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    FlashMessage.fire(
                        'Delete Action Cancelled',
                        'App feature is safe :)',
                        'info'
                    );
                }
            })
        };
    </script>
@endpush
