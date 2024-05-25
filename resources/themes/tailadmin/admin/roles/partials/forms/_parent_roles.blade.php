<x-input-label for="parent_id">{{ __('Parent') }}</x-input-label>

<x-select class="w-full mt-2" id="parent_id" name="parent_id">
    <option value="" selected>---</option>
    @foreach($roles as $role)
        <option value="{{ $role->id }}"
                {{ old('parent_id', $parent_id ?? null) == $role->id ? 'selected' : '' }}
                @isset($role_id) {{ $role_id === $role->id ? 'disabled' : '' }} @endisset>
            {{ $role->name }}
        </option>
    @endforeach
</x-select>

<x-input-error class="mt-2" :messages="$errors->get('parent_id')" />
