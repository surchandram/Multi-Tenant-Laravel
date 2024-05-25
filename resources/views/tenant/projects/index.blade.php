<x-tenant-layout>

    <x-slot name="pageTitle">
        {{ page_title(__('Projects')) }}
    </x-slot>

    <x-slot name="title">
        {{ __('Projects') }}
    </x-slot>

    <section>
        <x-card class="mb-4">
            <x-slot name="header">
                <p class="font-semibold text-slate-500 mt-2">{{ __('Browse your team\'s projects below') }}</p>
            </x-slot>

            <!-- content -->
            <div class="flex flex-col">
                @forelse($projects as $project)
                    <a href="{{ route('tenant.projects.show', $project) }}"
                        class="w-full px-4 py-2 flex items-center justify-between hover:bg-slate-100 focus:bg-slate-100"
                    >
                        <div>{{ $project->name }}</div>

                        <div class="flex items-center gap-4">
                            <form method="POST" action="{{ route('tenant.projects.destroy', $project) }}">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">{{ __('Delete') }}</x-danger-button>
                            </form>
                            <div class="px-4 py-2 text-white bg-blue-700 rounded-lg text-sm font-semibold">
                                {{ __(':count files', ['count' => $project->files_count]) }}
                            </div>
                        </div>
                    </a>
                @empty
                    <p>{{ __('No projects found.') }}</p>
                @endforelse
            </div>
        </x-card><!-- /.card -->
    </section><!-- /.row -->

    <section class="py-6">
        <x-card class="mb-4">
            <x-slot name="header">
                <h5 class="font-semibold text-sm tracking-wider">{{ __('Add Project') }}</h5>
            </x-slot><!-- /.card-header -->

            <div>
                <form method="POST" action="{{ route('tenant.projects.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="name">{{ __('Name') }}</x-input-label>
                        <x-input class="w-full mt-1" id="name" type="text" name="name" value="{{ old('name') }}" required />

                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div><!-- /.form-group -->

                    <div class="w-full flex justify-end mt-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section><!-- /.col -->
</x-tenant-layout>
