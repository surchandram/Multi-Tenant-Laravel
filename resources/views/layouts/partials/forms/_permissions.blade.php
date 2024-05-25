<div>
    <x-input-label>{{ __('Permissions') }}</x-input-label>

    <div class="mb-2" id="permissions">
        <div class="inline-flex items-center gap-2 mt-2">
            <x-checkbox class="mr-2" id="selectAll" data-target="#permissions" />
            <x-input-label class="" for="selectAll">Assign all permissions</x-input-label>
        </div>

        @foreach ($permissions->where('type', array_search($class, config('laravel-roles.models')))->chunk($chunk = 3) as $permissionsGroup)
            <div class="w-full flex flex-col md:grid grid-cols-3 gap-2 mt-4">
                @foreach ($permissionsGroup as $permission)
                    <div class="py-1">
                        <div class="inline-flex items-center gap-2">
                            <x-checkbox
                                class="@error('permissions[{{ $permission->id }}]') border-red-300 @enderror"
                                id="pm-{{ $permission->id }}"
                                name="permissions[{{ $permission->id }}]"
                                :value="$permission->id"
                                :checked="in_array($permission->id, old('permissions', $permission_ids ?? []))"
                                data-toggle="#permissions"
                            />

                            <x-input-label class="ml-2" for="pm-{{ $permission->id }}">
                                {{ $permission->name }}
                            </x-input-label>
                        </div><!-- /.custom-control -->

                        @error('permissions[{{ $permission->id }}]')
                            <p class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                        @enderror
                    </div>

                    @if ($loop->count < $chunk && $loop->last)
                        <div class="">
                            &nbsp;
                        </div>
                    @endif
                @endforeach
            </div><!-- /.form-group -->
        @endforeach
    </div>

    @if ($errors->has('permission_id'))
        <p class="invalid-feedback">{{ $errors->first('permission_id') }}</p>
    @endif

</div>
