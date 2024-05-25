@extends('dashboard.layouts.default')

@section('title', page_title(__('Dashboard')))

@section('header')
    <div class="p-4 md:p-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-4">
        <div class="grid grid-cols-6 gap-4">
            <!-- User Summary -->
            <div class="col-span-full md:col-span-3 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white dark:bg-slate-800">
                        <h3 class="text-sm font-medium mb-3">
                            {{ __('Hi, :name', ['name' => Auth::user()->first_name]) }}
                        </h3>

                        <p>
                            {{ Settings::get('pages.dashboard.user_summary_card') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Personal Team Create Link -->
            @if(Settings::get('teams.personal'))
                @if(!Auth::user()->hasPersonalTeam)
                    <div class="col-span-full md:col-span-3 sm:px-6 lg:px-8">
                        <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                        >
                            <a href="{{ route('teams.personal.setup', ['personal' => true]) }}" class="flex flex-col">
                                <div class="p-6 bg-white dark:bg-slate-800 dark:text-blue-300">
                                    <p>{{ Settings::get('pages.dashboard.personal_team_create_label') }}</p>

                                    <h3 class="text-sm font-medium mt-3 flex items-center justify-between">
                                        {{ __('Start here') }}
                                        <i class="ml-auto bi bi-arrow-right"></i>
                                    </h3>
                                </div>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="col-span-full md:col-span-3 sm:px-6 lg:px-8">
                        <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                        >
                        <div class="h-full p-6">{{ __('Personal team metrics here.') }}</div>
                        </div>
                    </div>
                @endif
            @else
                <div class="col-span-full md:col-span-3 sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="h-full p-6">{{ __('User metrics here.') }}</div>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-6 gap-4 mt-6">
            <!-- Team Create Link -->
            <div class="col-span-full md:col-span-3 sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <a href="{{ route('teams.create') }}" class="flex flex-col">
                        <div class="p-6 bg-white dark:bg-slate-800 dark:text-blue-300">
                            <p>{{ Settings::get('pages.dashboard.create_team_label') }}</p>

                            <h3 class="text-sm font-medium mt-3 flex items-center justify-between">
                                {{ __('Start here') }}
                                <i class="ml-auto bi bi-arrow-right"></i>
                            </h3>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Support Links -->
            <div class="col-span-full md:col-span-3 sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 bg-white dark:bg-slate-800 dark:text-blue-300">
                        <p>
                            {{ __('Checkout documentation') }}&comma;
                            <a target="_blank" href="{{ route('docs.index') }}" class="underline">
                                {{ __('here') }}
                            </a>
                        </p>

                        <a href="{{ route('support.tickets.create') }}" class="flex flex-col">
                            <h3 class="text-sm font-medium mt-3 flex items-center justify-between">
                                {{ __('Open a support ticket') }}
                                <i class="ml-auto bi bi-arrow-right"></i>
                            </h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
