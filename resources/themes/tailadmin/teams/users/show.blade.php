<x-team-layout :team="$team">

    <x-slot name="pageTitle">
        {{ page_title(__(':user | :name | Teams', ['user' => $user->name, 'name' => $team->name])) }}
    </x-slot>

    <section>
        <x-card class="card mb-4">
            <x-slot name="header">
                <h5 class="text-lg font-semibold">{{ $user->name }}</h5>
            </x-slot>

            <div class="card-body">
                <p class="mb-0">
                    {{ __('Member since') }}&colon;
                    <strong>
                        {{ optional($user->teams->first()->pivot->created_at)->toFormattedDateString() }}
                    </strong>
                </p>
            </div><!-- /.card-body -->
        </x-card><!-- /.card -->

        @can('assign team roles', $team)
            <x-card class="card mb-4">
                <x-slot name="header">
                    <h5 class="text-lg font-semibold">{{ __('Roles') }}</h5>
                </x-slot>

                <div class="w-full">
                    <div class="table-responsive-sm overflow-x-auto md:overflow-hidden">
                        <table class="w-full divide-y divide-gray-300 mb-0">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-2 text-xs text-left text-gray-500">{{ __('Name') }}</th>
                                    <th scope="col" class="px-6 py-2 text-xs text-left text-gray-500">{{ __('Since') }}</th>
                                    <th scope="col" class="px-6 py-2 text-xs text-left text-gray-500">{{ __('Expired') }}</th>
                                    <th scope="col" class="px-6 py-2 text-xs text-left text-gray-500">&nbsp;</th>
                                </tr>
                            </thead><!-- /thead -->
                            <tbody class="bg-white divide-y divide-gray-300">
                            @foreach($user->roles as $role)
                                <tr class="whitespace-nowrap">
                                    <td class="px-6 py-4">
                                        <strong>{{ $role->name }}</strong>
                                        @if(isset(optional($role->pivot)->expires_at) && now()->gte(optional($role->pivot)->expires_at))
                                            <span class="px-2 py-1 ml-2 text-xs text-white font-semibold rounded-full bg-red-500">
                                                {{ __('Expired') }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 ml-2 text-xs text-white font-semibold rounded-full bg-blue-500">
                                                {{ __('Active') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(($start = optional($role->pivot)->created_at))
                                            <time title="{{ $start }}">
                                                {{ \Illuminate\Support\Carbon::parse($start)->toFormattedDateString() }}
                                            </time>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(($time = optional($role->pivot)->expires_at))
                                            <time title="{{ $time }}">
                                                {{ \Illuminate\Support\Carbon::parse($time)->diffForHumans() }}
                                            </time>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">&nbsp;</td>
                                </tr><!-- /tr -->
                            @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div>
            </x-card><!-- /.card -->
        @endcan
    </section>
</x-team-layout>
