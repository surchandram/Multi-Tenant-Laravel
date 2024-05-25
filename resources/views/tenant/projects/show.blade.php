<x-tenant-layout>
    <x-slot name="pageTitle">
        {{ page_title(__(':name | Projects', ['name' => $project->name])) }}
    </x-slot>

    <section class="">
        <x-card no-pad>
            <x-slot name="header">
                <div x-data="{ edit: false }" class="w-full py-2">
                    <h5 x-show="! edit" class="font-semibold text-sm tracking-wider">
                        {{ $project->name }}

                        <x-link-button class="ml-2 px-2 py-1" ring no-pad href="#" @click.prevent="edit = true" variant="blue" rounded="lg" size="xs" light>
                            {{ __('Edit') }}
                        </x-link-button>
                    </h5>

                    @can('update team')
                        <form x-show="edit"
                            style="display:none"
                            x-cloak class="p-6 bg-slate-100"
                            action="{{ route('tenant.projects.update', $project) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PATCH')

                            <p class="text-slate-500 font-semibold text-sm mb-2">
                                {{ __('You\'re currently editing your project') }}
                            </p>

                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <x-input
                                    class="mr-2 flex-1"
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $project->name) }}"
                                    required
                                />

                                <x-secondary-button @click.prevent="edit = false">{{ __('Cancel') }}</x-secondary-button>
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    @endcan
                </div>
            </x-slot>

            <div class="px-6 py-2">
                <div class="flex flex-col">
                    @forelse($project->files as $file)
                        <div
                           class="px-4 py-2 flex items-center hover:bg-slate-100 text-blue-500 text-sm cursor-pointer">
                            <a class="hover:underline focus:underline mr-auto" href="{{ route('tenant.projects.files.show', [$project, $file]) }}">
                                {{ $file->name }}
                            </a>

                            <div class="font-semibold text-slate-900 text-xs">
                                {{ __('Uploaded by :name', ['name' => optional($file->user)->name]) }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 font-semibold">{{ __('No files uploaded.') }}</p>
                    @endforelse
                </div>
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section><!-- /.row -->

    <section class="py-10">
        <x-card>
            <x-slot name="header">
                <h5 class="font-semibold text-sm tracking-wider">{{ __('Add a file') }}</h5>
            </x-slot><!-- /.card-header -->

            <div>
                <form method="POST" action="{{ route('tenant.projects.files.store', $project) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="">
                        <x-input-label for="file">{{ __('Upload a file') }}</x-input-label>

                        <input
                            class="w-full px-2 py-1 mt-2 border-2 rounded-md shadow-sm border-indigo-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            id="file"
                            type="file"
                            name="file"
                            value="{{ old('file') }}"
                            required
                        />

                        <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    </div><!-- /.form-group -->

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>{{ __('Upload') }}</x-primary-button>
                    </div>
                </form>
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section><!-- /.col -->
</x-tenant-layout>
