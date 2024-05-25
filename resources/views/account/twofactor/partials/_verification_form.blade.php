<x-card class="mb-4">
    <div name="header">
        <h4 class="text-lg font-semibold mb-2">{{ __('Two Factor Authentication') }}</h4>

        <p class="text-xs text-slate-400 font-semibold">
            {{ __('Enter the verification code sent to you.') }}
        </p>
    </div><!-- /.card-header -->

    <div class="card-body">
        <form method="POST" action="{{ route('account.twofactor.verify') }}">
            @csrf

            <div class="flex flex-col mt-4  md:grid md:grid-cols-3 md:gap-4">
                <x-input-label for="verification_code" class="md:col-span-1">{{ __('Verification code') }}</x-input-label>

                <div class="md:col-span-2 mt-2 md:mt-0">
                    <x-input
                        id="verification_code"
                        type="text"
                        class="w-full"
                        name="verification_code"
                        value="{{ old('verification_code') }}"
                        required
                        autocomplete="new-verification_code"
                    />

                    <x-input-error :messages="$errors->get('verification_code')" />
                </div>
            </div><!-- /.form-group -->

            <div class="flex flex-col mt-4 md:grid md:grid-cols-3 md:gap-4">
                <div class="md:col-start-2 md:col-span-1">
                    <x-primary-button type="submit">
                        {{ __('Verify') }}
                    </x-prima-button>
                </div>
            </div><!-- /.form-group -->
        </form>

        <div class="py-2 mt-4 border-t border-x-gray-300"></div>

        <form method="POST" action="{{ route('account.twofactor.destroy') }}">
            @csrf
            @method('DELETE')

            <div class="flex flex-col mt-4  md:grid md:grid-cols-3 md:gap-4">
                <div class="md:col-start-2 md:col-span-1">
                    <x-button type="submit" light bold size="sm" class="uppercase">
                        {{ __('Cancel Verification') }}
                    </x-button>
                </div>
            </div><!-- /.form-group -->
        </form>
    </div><!-- /.card-body -->
</x-card><!-- /.card -->
