<x-tenant-layout>
    <x-slot name="pageTitle">{{ page_title(tenant()->name) }}</x-slot>

    <section>
        <x-card class="card mb-4">
            <x-slot name="header">
                <h5 class="text-lg font-semibold">{{ __('Dashboard') }}</h5>
            </x-slot>

            <!-- Content -->
            <div class="text-lg">
                {{ __('This is your team dashboard') }}
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->
    </section><!-- /.row -->
</x-tenant-layout>
