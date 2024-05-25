<x-app-layout>
    <x-slot name="pageTitle">
        {{ page_title(__('Developers Panel')) }}
    </x-slot>

    <x-slot name="header" class="card mb-2">
        <h3 class="text-lg font-semibold">{{ __('Developers Panel') }}</h3>
    </x-slot>

    <section>
        <div class="px-6 py-4">
            <div class="mb-5">
                <x-passport-clients />
            </div>

            <div class="mb-5">
                <x-passport-authorized-clients />
            </div>

            <div class="mb-5">
                <x-passport-personal-access-tokens />
            </div>
        </div>
    </section>
</x-app-layout>
