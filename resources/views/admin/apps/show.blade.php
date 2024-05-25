@extends('admin.layouts.default')

@section('title', page_title($app->name))

@section('content')
    <!-- Actions -->
    <div class="flex items-center justify-end gap-2 mb-4" role="group">
        <div class="text-lg font-semibold">{{ __('Actions') }}</div>
        <x-link-button
            size="sm"
            light
            bold
            rounded="md"
            href="{{ route('admin.apps.edit', $app) }}"
        >
            {{ __('Edit') }}
        </x-link-button>
    </div>

    <!-- App Summary and Features -->
    <x-card no-wrap-pad no-pad class="mb-5">
        <x-slot name="header" class="border-b">
            <h4 class="text-lg font-semibold tracking-wider mb-2">{{ $app->name }}</h4>

            <p class="text-sm text-slate-800">{{ __('Details of app\'s plans, features and more.') }}</p>
        </x-slot><!-- /.card-header -->

        <div class="flex flex-col mb-4">
            <div class="div px-6 py-2">
                <h4 class="text-lg font-semibold text-slate-700">{{ __('Features') }}</h4>
            </div>

            @forelse ($app->features as $feature)
                <div class="p-6">
                    <h4 class="text-sm font-semibold">{{ $feature->feature->name }}</h4>

                    <p class="mt-3 text-sm font-semibold">
                        {{ __('Status: :status', ['status' => $feature->feature->usable ? __('Active') : __('Disabled')]) }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-slate-500">
                    {{ __('No features defined yet.') }}
                </p>
            @endforelse
        </div>
    </x-card>

    <!-- Billing -->
    <x-card no-wrap-pad no-pad class="mb-5">
        <div class="flex flex-col mb-4">
            <div class="px-6 py-2">
                <h4 class="text-lg font-semibold text-slate-700">{{ __('Billing') }}</h4>
            </div>

            <div class="px-6 py-2">
                <p>
                    <span class="text-sm font-semibold">{{ __('Subscriptions: ') }}</span>
                    {{ $app->subscription ? 'Allowed' : 'Disabled' }}
                </p>
            </div>

            <div class="px-6 py-2">
                <p>
                    <span class="text-sm font-semibold">{{ __('Availability:') }}</span>

                    @if ($app->teams_only)
                        {{ __('Teams only') }}
                    @else
                        {{ __('Users and teams') }}
                    @endif
                </p>
            </div>

            @forelse ($app->plans as $plan)
                <div class="p-6">
                    <h4 class="text-sm font-semibold text-slate-700">{{ $plan->plan->name }}</h4>

                    <p class="mt-3 text-lg font-semibold">
                        {{ __('Price: :price', ['price' => $plan->plan->formatted_price]) }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-slate-500">
                    {{ __('No billing plans linked yet.') }}
                </p>
            @endforelse
        </div>
    </x-card><!-- /card -->
@endsection

