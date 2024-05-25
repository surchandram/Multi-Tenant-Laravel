@extends('dashboard.layouts.default')

@section('title', page_title(__('Projects')))

@section('dashboard.content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Projects') }}</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($projects as $project)
                            <a href="{{ route('dashboard.projects.show', $project) }}"
                               class="list-group-item list-group-item-action">
                                {{ $project->name }} &bull; {{ __(':count files', ['count' => $project->files_count]) }}
                            </a>
                        @empty
                            <p>{{ __('No projects found.') }}</p>
                        @endforelse
                    </div>
                </div><!-- /.card-body -->
            </div><!-- /.card -->

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Add Project') }}</h5>
                </div><!-- /.card-header -->

                <div class="card-body">
                    <form method="POST" action="{{ route('dashboard.projects.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required>

                            @error('name')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div><!-- /.form-group -->

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
