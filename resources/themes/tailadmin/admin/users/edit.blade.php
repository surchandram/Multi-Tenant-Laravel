@extends('admin.layouts.default')

@section('title', page_title(__('Edit User')))

@section('content')
    <x-card no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider">{{ $user->name }}</h4>

            <p class="text-sm text-slate-800">{{ __('Manage user\'s details and roles.') }}</p>
        </x-slot><!-- /.card-header -->

        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.roles.store', $user) }}">
                @csrf

                <div>
                    @include('admin.roles.partials.forms._roles')
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-input-label for="expires_at" class="mb-2">{{ __('Role expires at') }}</x-input-label>

                    <x-input
                        type="text"
                        class="w-full mt-2 datetimepicker form-control"
                        id="expires_at"
                        name="expires_at"
                        placeholder="{{ __('date role expires at') }}"
                        value="{{ old('expires_at') }}"
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('expires_at')" />

                    <p class="mt-2 text-xs font-semibold text-slate-500">
                        {{ __('You can leave the field blank and change it later.') }}
                    </p>
                </div><!-- /.form-group -->

                <div class="mt-4">
                    <x-button light size="sm" bold type="submit">
                        {{ __('Assign') }}
                    </x-button>
                </div>
            </form><!-- /form -->
        </div><!-- /.card-body -->
    </x-card><!-- /card -->

    <x-card no-pad no-wrap-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h5 class="text-lg font-semibold mb-3">{{ __('Roles') }}</h5>

            <p class="text-sm text-slate-800">{{ __('A list of user\'s roles.') }}</p>
        </x-slot><!-- /.card-header -->

        @if ($user->roles->count())
            <x-table-responsive responsive>
                <x-slot name="header">
                    <x-table-col-head>{{ __('Name') }}</x-table-col-head>
                    <x-table-col-head>{{ __('Expires') }}</x-table-col-head>
                    <x-table-col-head>&nbsp;</x-table-col-head>
                </x-slot>

                <!-- tbody -->
                @foreach ($user->roles as $role)
                    <x-table-row>
                        <x-table-col>
                            {{ $role->name }}
                            @if (($ancestors = $role->ancestors)->count())
                                {{ ' - (' . implode(' / ', $ancestors->pluck('name')->toArray()) . ')' }}
                            @endif
                        </x-table-col>
                        <x-table-col>{{ $role->pivot->expires_at }}</x-table-col>
                        <x-table-col>
                            @if (!$role->pivot->expires_at || now()->lt(optional($role->pivot)->expires_at))
                                <div class="flex items-center gap-4">
                                    <x-link-button themed
                                        href="{{ route('admin.users.roles.edit', [$user, $role]) }}"
                                        size="sm"
                                        light
                                        rounded="md"
                                    >
                                        {{ __('Edit') }}
                                    </x-link-button>

                                    <!-- Role revoke Form -->
                                    <form
                                        id="rev-role-{{ $role->id }}-form"
                                        action="{{ route('admin.users.roles.destroy', [$user, $role]) }}" method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')
                                    
                                        <x-link-button themed
                                            href="#"
                                            size="sm"
                                            light
                                            rounded="md"
                                            bg="bg-danger"
                                            onclick="event.preventDefault();
                                                    confirmDelete('rev-role-{{ $role->id }}-form', {{ json_encode($role) }});
                                            "
                                        >
                                            {{ __('Revoke') }}
                                        </x-link-button>
                                    </form>
                                </div>
                            @else
                                <span class="px-4 py-1 text-sm font-semibold bg-red-600 text-white rounded-full">
                                    {{ __('Role expired') }}
                                </span>
                            @endif
                        </x-table-col>
                    </x-table-row><!-- /tr -->
                @endforeach
            </x-table-responsive><!-- /.table -->
        @else
            <div class="p-6 card-body">
                <p class="text-sm font-semibold">{{ __('No roles found.') }}</p>
            </div><!-- /.card-body -->
        @endif
    </x-card><!-- /card -->
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, role) {
            // find form
            var form = document.getElementById(id);

            // config
            let config = _.merge(swalCustomConfirmOptions, {
                title: `<small>Are you sure you want to revoke <strong>${role.name}</strong> role from user?</small>`,
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
                        title: `${role.name} role is being revoked.`,
                        type: 'info'
                    });
                }
            })
        };
    </script>
@endpush
