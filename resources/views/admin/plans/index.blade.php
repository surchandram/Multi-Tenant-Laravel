@extends('admin.layouts.default')

@section('title', page_title(__('Plans')))

@section('content')
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-semibold tracking-wider">{{ __('Plans') }}</h4>

        <aside class="btn-group">
            <x-link-button size="sm" light rounded="md" ring href="{{ route('admin.plans.create') }}" class="btnprimary">
                {{ __('Add a plan') }}
            </x-link-button>
            <!-- Filter Toggle Button -->
        </aside>
    </div>

    <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>

    <!-- Search -->
    <div class="flex flex-col mb-3">
        <form action="">
            <div class="w-full flex items-center gap-2 mb-3">
                <x-input
                    type="search"
                    class="flex-1 h-full"
                    name="search"
                    placeholder="{{ __('Search by name, provider id, feature name, feature key...') }}"
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

    @if($plans->count())
        <x-card clear-width no-pad no-wrap-pad class="mb-5">
            <x-table responsive class="-py-2">
                <x-slot name="header">
                    <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                    <x-table-col-head>{{ __('Type') }}</x-table-col-head>
                    <x-table-col-head>{{ __('Price') }}</x-table-col-head>
                    <x-table-col-head>{{ __('Subscribers') }}</x-table-col-head>
                    <x-table-col-head>{{ __('Status') }}</x-table-col-head>
                    <x-table-col-head>&nbsp;</x-table-col-head>
                </x-slot>

                <!-- tbody -->
                @foreach($plans as $plan)
                    <x-table-row hoverable striped>
                        <x-table-col bold>{{ $plan->name }}</x-table-col>
                        <x-table-col>{{ $plan->teams ? __('Teams') : __('Personal') }}</x-table-col>
                        <x-table-col bold>{{ $plan->formatted_price }}</x-table-col>
                        <x-table-col>{{ $plan->teams ? $plan->team_subscribers_count : $plan->subscribers_count }}</x-table-col>
                        <x-table-col>{{ $plan->usable ? 'Active' : 'Disabled' }}</x-table-col>
                        <x-table-col>
                            <div class="flex items-center gap-2" role="group">
                                <x-link-button size="sm" light rounded="md" ring href="{{ route('admin.plans.edit', $plan) }}"
                                    variant="blue">
                                    {{ __('Edit') }}
                                </x-link-button>
                                <x-link-button size="sm" light rounded="md" ring href="{{ route('admin.plans.features.index', $plan) }}"
                                    variant="teal">
                                    {{ __('Features') }}
                                </x-link-button>
                                <x-link-button size="sm" light rounded="md" ring href="{{ route('admin.plans.destroy', $plan) }}"
                                    variant="red"
                                    onclick="event.preventDefault();
                                            confirmDelete('del-plan-{{ $plan->id }}-form', {{ json_encode($plan) }});">
                                    {{ __('Delete') }}
                                </x-link-button>

                                <!-- Plan Delete Form -->
                                <form id="del-plan-{{ $plan->id }}-form"
                                        action="{{ route('admin.plans.destroy', $plan) }}"
                                        method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </x-table-col>
                    </x-table-row><!-- /tr -->
                @endforeach
            </x-table><!-- /table -->
        </x-card><!-- /.card -->

        {{ $plans->onEachSide(2)->links() }}
    @else
        <p class="text-lg font-slate-400">No plans to display.</p>
    @endif
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, plan) {
            // find form
            var form = document.getElementById(id);

            // config
            let config = _.merge(swalCustomConfirmOptions, {
                title: `<small>Are you sure you want to delete <strong>${plan.name}</strong> plan?</small>`,
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
                        title: `${plan.name} plan is being deleted.`,
                        type: 'info',
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    FlashMessage.fire(
                        'Delete Action Cancelled',
                        'Your plan is safe :)',
                        'info'
                    )
                }
            })
        };
    </script>
@endpush
