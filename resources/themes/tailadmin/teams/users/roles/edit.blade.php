<x-team-layout :team="$team">
    <x-slot name="pageTitle">
        {{ page_title(__('Change User Role | :name | Teams', ['name' => $team->name])) }}
    </x-slot>

    <section>
        <x-card class="card mb-4">
            <x-slot name="header">
                <h5 class="text-lg font-semibold mb-2">{{ __('Change User Role') }}</h5>

                <p class="text-sm mb-0">
                    {{ __(':name\'s currently holds \':role\' role', ['name' => $user->name, 'role' => optional($user->roles->first())->name]) }}
                </p>
            </x-slot><!-- /.card-header -->

            <div class="card-body">
                @if ($user->isOnlyAdminInTeam($team))
                    <p>
                        {{ __(':name is the only \'Admin\' left in your team.', ['name' => $user->name]) }}
                        {{ __('Assign the \'Admin\' role to another user first.') }}
                    </p>
                @else
                    <form method="POST" action="{{ route('teams.users.roles.update', [$team, $user]) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <x-input-label for="name">{{ __('Role') }}</x-input-label>
                            <x-select name="role_id" id="role_id"
                                class="w-full mt-2 @error('role_id') is-invalid @enderror">
                                <option value="">---</option>
                                @foreach ($team->roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $user->hasRole($role->slug) || old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </x-select>

                            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                        </div><!-- /.form-group -->

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button type="submit" class="btn btn-primary">
                                {{ __('Change Role') }}
                            </x-primary-button>
                        </div>
                    </form>
                @endif
            </div><!-- /.card-body -->
        </x-card> <!-- /.card -->
    </section> <!-- /.row -->
</x-team-layout>
