@extends('admin.layouts.default')

@section('title', page_title(__('Apps')))

@section('content')
    <div
        x-data="FiltersMap(
            'modal-app-filters',
            @js(route('apps.filters.index')),
            @js(\Illuminate\Support\Arr::except(request()->query(), 'page'))
        )"
    >
        <!-- page header -->
        <div class="flex items-center justify-between">
            <h4 class="text-lg font-semibold tracking-wider">{{ __('Apps') }}</h4>
        
            <div class="flex items-center gap-4" role="group">
                <x-link-button themed size="sm" bold light rounded="md" href="{{ route('admin.apps.create') }}">
                    {{ __('Add App') }}
                </x-link-button>
            </div>
        </div>
        
        <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>
        
        <!-- Filters Modal -->
        <x-filters-modal-form id="modal-app-filters" />
            
            <!-- Search + Filter Buttons -->
            <div class="w-full flex flex-col md:items-center md:inline-flex md:flex-row gap-4 mb-3">
                <!-- Search -->
                <div class="flex flex-col flex-1 mb-3 md:mb-0">
                    <form method="GET" action="">
                        <template x-for="(value, name) in selected">
                            <input type="hidden" x-bind:name="name" x-bind:value="value">
                        </template>

                        <div class="flex items-center gap-2">
                            <x-input
                                type="search"
                                class="flex-1 h-full"
                                   name="search"
                                   placeholder="{{ __('Search by title, slug...') }}"
                                   value="{{ old('search', request('search')) }}"
                                   aria-describedby="button-search"
                            />
                
                            <div class="input-group-append">
                                <x-button light size="sm" bold class="primary" type="submit" id="button-search">{{ __('Search') }}</x-button>
                            </div>
                        </div><!-- /.input-group -->
                    </form>
                </div>
                
                <!-- Filter Toggle Button -->
                <x-button
                    type="button"
                    no-margin
                    bg="teal"
                    size="sm"
                    light
                    bold
                    class="focus:ring"
                    tabindex="-1"
                    @click.prevent="showFiltersModal"
                >
                    {{ __('Filters') }}
                </x-button>
                
                <!-- Filter Clear Button -->
                <x-link-button themed
                    href="{{ route('admin.apps.index') }}"
                    no-margin
                    variant="slate"
                    rounded="md"
                    shades="800,800,800"
                    size="sm"
                    light
                    bold
                    class="text-center focus:ring"
                    tabindex="-1"
                    x-show="hasSelectedFilters"
                    style="display: none;"
                >
                    {{ __('Clear Filters') }}
                </x-link-button>
            </div>
        
        <div class="w-full mt-4 mb-4 border-t border-gray-300"></div>
        
        <x-card no-pad no-wrap-pad class="card mb-5">
            <div class="-my-2">
                <x-table-responsive responsive>
                    <x-slot name="header">
                        <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Key') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Status') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Subscription') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Availability') }}</x-table-col-head>
                        <x-table-col-head>{{ __('Date Added') }}</x-table-col-head>
                        <x-table-col-head>&nbsp;</x-table-col-head>
                    </x-slot>
                
                    <!-- tbody -->
                    @foreach($apps as $app)
                        <x-table-row>
                            <x-table-col-head>
                                <p class="mb-4">
                                	{{ $app->name }}
                                </p>

                                @if ($app->primary)
		                            <span class="px-2 py-1 rounded text-center text-xs font-semibold text-white bg-blue-600">
		                            	{{ __('Default App') }}
		                            </span>
	                            @endif
                            </x-table-col-head>
                            <x-table-col>{{ $app->key }}</x-table-col>
                            <x-table-col>{{ $app->usable ? __('Active') : __('Disabled') }}</x-table-col>
                            <x-table-col>
                                <p>{{ $app->subscription ? 'Allowed' : 'Disabled' }}</p>

                                @if ($app->subscription)
                                    <p class="text-xs text-white font-semibold mt-4">
                                        <span class="px-2 py-1 bg-blue-600 rounded">
                                            {{ __(':value plans', ['value' => $app->plans_count]) }}
                                        </span>
                                    </p>
                                @endif
                            </x-table-col>
                            <x-table-col>
                            	{{ $app->teams_only ? __('For teams') : __('Users and teams') }}
                            </x-table-col>
                            <x-table-col>{{ $app->created_at->diffForHumans() }}</x-table-col>
                            <x-table-col>
                                <div class="flex items-center gap-2" role="group">
                                    <x-link-button themed
                                        size="sm"
                                        light
                                        bold
                                        rounded="md"
                                        href="{{ route('admin.apps.edit', $app) }}"
                                    >
                                        {{ __('Edit') }}
                                    </x-link-button>

                                    <x-link-button themed
                                        size="sm"
                                        light
                                        bold
                                        rounded="md"
                                        href="{{ route('admin.apps.show', $app) }}"
                                    >
                                        {{ __('View') }}
                                    </x-link-button>

                                    <div class="relative">
                                    	<x-dropdown align="right">
                                    		<x-slot name="trigger">
                                    			<x-button
                                    				type="button"
                                    			    bg="teal"
                                    			    size="sm"
                                    			    light
                                    			    bold
                                    			    rounded="md"
                                                    no-pad
                                                    class="flex"
                                    			>
                                                    <div
                                                        class="
                                                            w-12
                                                            h-full
                                                            px-2
                                                            py-2
                                                            rounded-l-md
                                                            bg-teal-200
                                                            text-center
                                                            text-teal-600
                                                        "
                                                    >
                                                        {{ $app->features_count }}
                                                    </div>
                                    			    <div class="px-4 py-2">
                                                        {{ __('Features') }}
                                                    </div>
                                    			</x-button>
                                    		</x-slot>
                                    	
                                    		<!-- Content -->
                                    		<x-slot name="content">
                                    			<x-dropdown-link
                                    				href="{{ route('admin.apps.features.create', $app) }}"
	                                			>
	                                				{{ __('Add feature') }}
	                                			</x-dropdown-link>

	                                			<!-- Features index -->
                                    			<x-dropdown-link
                                    				href="{{ route('admin.apps.features.index', $app) }}"
	                                			>
	                                				{{ __('Features') }}
	                                			</x-dropdown-link>
                                    		</x-slot>
                                    	</x-dropdown>
                                    </div>
                
                                    <!-- App Delete Form -->
                                    {{-- <form
                                        id="del-app-{{ $app->id }}-form"
                                        action="{{ route('admin.apps.destroy', $app) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')
                                            
                                        <x-link-button themed
                                            size="sm"
                                            light
                                            bold
                                            rounded="md"
                                            bg="bg-danger"
                                            href="{{ route('admin.apps.destroy', $app) }}"
                                            onclick="
                                                event.preventDefault();
                                                confirmDelete('del-app-{{ $app->id }}-form', {{ json_encode($app) }});"
                                        >
                                            {{ __('Delete') }}
                                        </x-link-button>
                                    </form> --}}
                                </div>
                            </x-table-col>
                        </x-table-row><!-- /tr -->
                    @endforeach
                </x-table-responsive><!-- /table -->
            </div>
        </x-card><!-- /.card -->
    </div>

    {{ $apps->onEachSide(2)->links() }}
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, app) {
            // find form
            var form = document.getElementById(id);

            // config
            let config = _.merge(swalCustomConfirmOptions, {
                title: `<small>Are you sure you want to delete <strong>${app.name}</strong> app?</small>`,
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
                        title: `${app.name} app is being deleted.`,
                        type: 'info'
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    FlashMessage.fire(
                        'Delete Action Cancelled',
                        'Your app is safe :)',
                        'info'
                    );
                }
            })
        };
    </script>
@endpush
