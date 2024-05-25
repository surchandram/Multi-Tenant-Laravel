@props([
    'team'
])

@php
    $count = isset($users) ? optional($users)->total() : $team->users->count();
    $limit = optional($team->plan->feature('users'))->limit ?? '0';
@endphp

@if($team->hasSubscription())
    <p class="text-sm">
        {!! __("You've used :count out of :limit available user slots.", ['count' => "<strong>{$count}</strong>", 'limit' => "<strong>{$limit}</strong>"]) !!}
    </p>
@endif
