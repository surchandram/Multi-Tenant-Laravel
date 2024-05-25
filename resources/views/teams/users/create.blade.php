<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__('Add User | :name - Teams', ['name' => $team->name])) }}
    </x-slot>


    <!-- Main -->
    <section>
        <x-card class="mb-4">
            <x-slot name="card-header">
                <h5 class="text-lg font-semibold">{{ __('Add a User') }}</h5>
            </x-slot><!-- /.card-header -->

            <div>
                <form method="POST" action="{{ route('teams.users.store', $team) }}">
                    @csrf

                    <div>
                        <x-input-label for="name">{{ __('Name') }}</x-input-label>
                        <x-input
                            id="name"
                            type="text"
                            class="w-full mt-1"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                        />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div><!-- /.form-group -->

                    <div class="mt-4">
                        <x-input-label for="email">{{ __('E-Mail Address') }}</x-input-label>
                        <x-input
                            id="email"
                            type="email"
                            class="w-full mt-1"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                        />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div><!-- /.form-group -->

                    <div class="mt-4">
                        <x-input-label for="name">{{ __('Role') }}</x-input-label>
                        <x-select name="role_id" id="role_id"
                            class="w-full mt-1">
                            <option value="">---</option>
                            @foreach ($team->roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </x-select>

                        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                    </div><!-- /.form-group -->

                    <div class="flex items-center justify-end mt-4">
                        <x-button type="submit" class="" bold light>
                            {{ __('Add User') }}
                        </x-button>
                    </div>
                </form>
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section><!-- /.row -->
</x-team-layout>
