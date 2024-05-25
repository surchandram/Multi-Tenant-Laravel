<x-input-label>{{ __('Permissions') }}</x-input-label>

<div class="mt-4 mb-2" id="permissions">
    @foreach($permissions->groupBy('type') as $type => $permissionsType)
        <div class="flex flex-col space-y-4 mt-4 border-t first:border-t-0">
            <div class="w-full py-2">
                <div class="inline-flex items-center gap-2">
                    <x-input
                        class="rounded-md select-all permissions-toggle"
                        id="selectAll{{ $type }}"
                        type="checkbox"
                        data-target="permissions-{{ $type }}"
                    />

                    <x-input-label for="selectAll{{ $type }}" class="">
                        {{ config('laravel-roles.permitables')[$type] ?? $type  }}
                        <span class="ml-1">({{ __('Check to assign all permissions') }})</span>
                    </x-input-label>
                </div>

                @foreach($permissionsType->chunk($chunk = 3) as $permissionsGroup)
                    <div class="flex flex-col gap-4 md:grid md:grid-cols-3">
                        @foreach($permissionsGroup as $permission)
                            <div class="mt-4">
                                <div class="inline-flex items-center gap-2">
                                    <x-input
                                        class="rounded-md permission-item permissions[{{ $permission->id }}]"
                                        id="pm-{{ $permission->id }}"
                                        name="permissions[{{ $permission->id }}]"
                                        type="checkbox"
                                        data-toggle="permissions-{{ $type }}"
                                        :value="$permission->id"
                                        :checked="in_array($permission->id, old('permissions', $permission_ids ?? []))"
                                    />

                                    <x-input-label for="pm-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </x-input-label>

                                </div><!-- /.custom-control -->

                                <x-input-error class="mt-2" :messages="$errors->get('permissions[{{ $permission->id }}]')" />
                            </div><!-- /.form-group -->
                        @endforeach
                    </div><!-- /.form-group -->
                @endforeach
            </div>
        </div>
    @endforeach
</div>

@if($errors->has('permission_id'))
    <x-input-error class="mt-2" :messages="$errors->get('permission_id')" />
@endif
