@extends('dashboard.layouts.default')

@section('title', page_title(__('Dashboard')))

@section('dashboard.content')
    <div class="row">
        <div class="col-md-12">
            <h3>{{ __('Dashboard') }}</h3>

            <hr>

            <p>{{ __('Hi, This is your awesome dashboard. We hope you build something great!!!') }}</p>
        </div>
    </div>
@endsection
