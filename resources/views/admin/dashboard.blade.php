@extends('admin.layouts.default')

@section('title', page_title(__('Dashboard')))

@section('content')
    <h2 class="text-xl font-semibold tracking-wider mb-3">{{ __('Dashboard') }}</h2>

    <div class="w-full py-4 border-t border-gray-300"></div>

    <!-- Apps -->
    <div class="mt-4 mb-4">
        <h3 class="text-lg font-semibold text-slate-600">{{ __('Apps') }}</h3>
    </div>

    <div class="grid gap-4 md:gap-x-12 md:grid-cols-3 mb-4">
        <div>
            <a href="{{ route('admin.apps.create') }}">
                <x-card no-wrap-pad class="hover:bg-slate-200">
                    <div class="flex flex-col items-center justify-between">
                        <i class="text-3xl icon-plus"></i>
            
                        <h4 class="py-4 mt-4 text-lg">&nbsp;</h4>
                        
                        <p class="text-2xl font-semibold text-slate-700">
                            {{ __('Add an app') }}
                        </p>
                    </div>
                </x-card>
            </a>
        </div>

        <div>
            <x-card no-wrap-pad>
                <x-slot name="header">
                    <i class="text-3xl text-teal-700 icon-rocket"></i>
                </x-slot>

                <h4 class="mb-4 text-lg text-slate-700 font-semibold">
                    {{ __('Active Apps') }}
                </h4>

                <p class="text-2xl font-semibold text-teal-700">
                    {{ $activeApps }}
                </p>
            </x-card>
        </div>

        <div>
            <x-card no-wrap-pad>
                <x-slot name="header">
                    <i class="text-3xl icon-rocket"></i>
                </x-slot>

                <h4 class="mb-4 text-lg text-slate-700 font-semibold">
                    {{ __('Total Apps') }}
                </h4>

                <p class="text-2xl font-semibold text-indigo-700">
                    {{ $apps }}
                </p>
            </x-card>
        </div>
    </div>

    <div class="w-full py-4"></div>

    <!-- Users Stats -->
    <div class="mt-4 mb-4">
        <h3 class="text-lg font-semibold text-slate-600">{{ __('Users') }}</h3>
    </div>

    <div class="grid md:grid-cols-3 gap-4 py-6 mb-4">
        <div>
            <x-card no-wrap-pad>
                <x-slot name="header">
                    <i class="text-xl icon-user"></i>
                </x-slot>

                <h4 class="mb-4 text-lg text-slate-700 font-semibold">
                    {{ __('Users') }}
                </h4>
                <p class="text-2xl font-semibold text-indigo-700">
                    {{ $users }}
                </p>
            </x-card><!-- /.callout -->
        </div><!-- /.col -->

        <div>
            <x-card no-wrap-pad>
                <x-slot name="header">
                    <i class="text-xl icon-user"></i>
                </x-slot>

                <h4 class="mb-4 text-lg text-slate-700 font-semibold">
                    {{ __('Users registered this month') }}
                </h4>
                <p class="text-2xl font-semibold text-teal-700">
                    {{ $monthlyNewUsers }}
                </p>
            </x-card><!-- /.callout -->
        </div><!-- /.col -->

        <div>
            <x-card no-wrap-pad>
                <x-slot name="header">
                    <i class="text-xl icon-people"></i>
                </x-slot>

                <h4 class="mb-4 text-lg text-slate-700 font-semibold">
                    {{ __('Teams') }}
                </h4>
                <p class="text-2xl font-semibold text-blue-700">
                    {{ $teams }}
                </p>
            </x-card><!-- /.callout -->
        </div><!-- /.col -->
    </div><!-- /.row -->

    <!-- Tickets -->
    <div class="mt-4 mb-4">
        <h3 class="text-lg font-semibold text-slate-600">{{ __('Tickets') }}</h3>
    </div>
    <div class="grid gap-4 md:gap-x-12 md:grid-cols-3">
        @foreach (\Saasplayground\SupportTickets\SupportTickets::getStatusMap() as $status)
            <div
                x-data="{
                    count: 0,
                    error: '',
                    init() {
                        this.getStats()
                    },
                    getStats() {
                        this.error = ''
                        axios.get(
                            @js(route('admin.support.tickets.stats.status', ['status' => $status]))
                        ).then((response) => {
                            this.count = response.data.count
                        }).catch(() => {
                            this.error = 'Failed loading!'
                        })
                    }
                }"
                class="mb-12 lg:mb-0"
            >
                <div class="rounded-lg shadow-lg h-full block bg-white">
                  <div class="flex justify-center p-6">
                    @if ($status == \Saasplayground\SupportTickets\SupportTickets::STATUS_OPEN)
                        <div class="p-4 text-blue-600 self-start inline-block -mt-8">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="64"
                                height="64"
                                fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16"
                            >
                              <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
                              <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
                            </svg>
                        </div>
                    @elseif($status == \Saasplayground\SupportTickets\SupportTickets::STATUS_CLOSED)
                        <div class="p-4 text-red-600 self-start inline-block -mt-8">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="64"
                                height="64"
                                fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16"
                            >
                              <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                            </svg>
                        </div>
                    @else
                        <div
                            class="p-4 text-teal-600 self-start inline-block -mt-8"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="64"
                                height="64"
                                fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16"
                            >
                              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                              <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4" x-text="count"></h3>
                    <h5 class="text-lg font-medium mb-4">
                        {{ \Illuminate\Support\Str::title($status) }}
                    </h5>
                    <p class="text-gray-500">
                        <x-link-button
                            href="{{ route('admin.support.tickets.index', ['status' => $status]) }}"
                            no-pad
                            no-margin
                            is-text
                            size="sm"
                            bold
                            class="hover:underline"
                        >{{ __('View') }}</x-link-button>
                    </p>
                </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
        