<x-card class="mb-4">
    <x-slot name="header">
        <h4 class="text-lg font-semibold mb-2">{{ __('Two Factor Authentication') }}</h4>

        <p class="text-xs text-slate-400 font-semibold">
            {{ __('Enter your current password to disable two factor authentication.') }}
        </p>
    </x-slot><!-- /.card-header -->

    <div>
        <form method="POST" action="{{ route('account.twofactor.destroy') }}">
            @csrf
            @method('DELETE')

            <div class="flex flex-col mt-4  md:grid md:grid-cols-3 md:gap-4">
                <div class="md:col-start-2 md:col-span-1">
                    <x-primary-button type="submit">
                        {{ __('Disable') }}
                    </x-primary-button>
                </div>
            </div><!-- /.form-group -->
        </form>
    </div><!-- /.card-body -->
</x-card><!-- /.card -->
