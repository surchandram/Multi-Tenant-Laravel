@extends('admin.layouts.default')

@section('title', page_title(__('Manage Plan Features') . ' - ' . $plan->name))

@section('content')
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-semibold tracking-wider">{{ __('Plan Features') }}</h4>

        <div class="btn-group" role="group">
            <x-link-button
                size="sm"
                bold
                light
                rounded="md"
                href="{{ route('admin.plans.features.create', $plan) }}"
            >
                {{ __('Add new feature') }}
            </x-link-button>
        </div>
    </div>

    <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>

    <x-card no-pad no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <p class="text-sm font-semibold">
                {!! __('Manage features for plan :plan.', ['plan' => "<strong>{$plan->name}</strong>"]) !!}
            </p>
        </x-slot>

        <x-table responsive>
            <x-slot name="header">
                <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                <x-table-col-head>{{ __('Key') }}</x-table-col-head>
                <x-table-col-head>{{ __('Limit') }}</x-table-col-head>
                <x-table-col-head>{{ __('Default') }}</x-table-col-head>
                <x-table-col-head>&nbsp;</x-table-col-head>
            </x-slot><!-- /thead -->

            @foreach($features as $feature)
                <x-table-row>
                    <x-table-col>{{ $feature->feature->name }}</x-table-col>
                    <x-table-col>{{ $feature->feature->key }}</x-table-col>
                    <x-table-col>{{ ($limit = $feature->limit) == 0 ? __('Unlimited') : $limit }}</x-table-col>
                    <x-table-col>{{ $feature->default ? __('Default') : '-' }}</x-table-col>
                    <x-table-col>
                        <div class="flex items-center gap-2" role="group">
                            <x-link-button
                                size="xs"
                                bold
                                light
                                rounded="md"
                                href="{{ route('admin.plans.features.edit', [$plan, $feature]) }}"
                            >
                                {{ __('Edit') }}
                            </x-link-button>

                            <!-- Plan Feature Delete Form -->
                            <form id="del-plan-feature-{{ $feature->id }}-form"
                                action="{{ route('admin.plans.features.destroy', [$plan, $feature]) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <x-link-button
                                    size="xs"
                                    bold
                                    light
                                    rounded="md"
                                    href="{{ route('admin.plans.features.destroy', [$plan, $feature]) }}"
                                    variant="red"
                                    onclick="event.preventDefault();
                                            confirmDelete('del-plan-feature-{{ $feature->id }}-form', {{ json_encode($feature) }});"
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
        function confirmDelete(id, feature) {
            // find form
            var form = document.getElementById(id);

            // config
            let config = _.merge(swalCustomConfirmOptions, {
                title: `<small>Are you sure you want to delete <strong>${feature.feature.name}</strong> feature from plan?</small>`,
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
                        title: `${feature.feature.name} feature is being deleted from plan.`,
                        type: 'info'
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    FlashMessage.fire(
                        'Delete Action Cancelled',
                        'Plan feature is safe :)',
                        'info'
                    );
                }
            })
        };
    </script>
@endpush
