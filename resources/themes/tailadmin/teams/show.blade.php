<x-team-layout :team="$team">

    @section('title', page_title(__(':name | Account Overview', ['name' => $team->name])))

    <x-slot name="title">
        {{ __('Account Overview') }}
    </x-slot>
    
    @section('content')
        <section>
            <x-card class="mb-4">
                <x-slot name="header">
                    <h5 class="text-lg font-semibold trackng-wider">{{ __('Account Overview') }}</h5>
                </x-slot>

                <div>
                    {{ __('This is your team account area') }}
                </div><!-- /.card-body -->
            </x-card><!-- /.card -->
        </section><!-- /.row -->
    @endsection
</x-team-layout>
