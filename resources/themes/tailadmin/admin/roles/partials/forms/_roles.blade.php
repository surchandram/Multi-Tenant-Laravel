<div>
    <x-input-label for="role_id">{{ __('Role') }}</x-input-label>

    <x-select class="w-full mt-2" id="role_id" name="role_id">
        <option value="" selected>---</option>
        @foreach ($roles as $roleGroup)
            @if ($roleGroup->children->count())
                <optgroup label="{{ $roleGroup->name }}">
                    @foreach ($roleGroup->children as $role)
                        <option value="{{ $role->id }}"
                            {{ old('role_id', $role_id ?? null) == $role->id ? ' selected' : '' }}
                            {{ !$role->usable ? ' disabled' : '' }}
                        >
                            {{ $role->name }}
                        </option>
                    @endforeach
                </optgroup>
            @else
                <option value="{{ $roleGroup->id }}"
                    {{ old('role_id', $role_id ?? null) == $roleGroup->id ? ' selected' : '' }}
                    {{ !$roleGroup->usable ? ' disabled' : '' }}
                >
                    {{ $roleGroup->name }}
                </option>
            @endif
        @endforeach
    </x-select>

    <x-input-error class="mt-2" :messages="$errors->get('role_id')" />
</div>
