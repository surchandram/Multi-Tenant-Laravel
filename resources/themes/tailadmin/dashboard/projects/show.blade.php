@extends('dashboard.layouts.default')

@section('title', page_title(__(':name - Projects', ['name' => $project->name])))

@section('dashboard.content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ $project->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($project->files as $file)
                            <a href="{{ route('dashboard.projects.files.show', [$project, $file]) }}"
                               class="list-group-item list-group-item-action">
                                {{ $file->name }}
                            </a>
                        @empty
                            <p>{{ __('No files uploaded.') }}</p>
                        @endforelse
                    </div>
                </div><!-- /.card-body -->
            </div><!-- /.card -->

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Add a file') }}</h5>
                </div><!-- /.card-header -->

                <div class="card-body">
                    <form method="POST" action="{{ route('dashboard.projects.files.store', $project) }}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="file">{{ __('Upload a file') }}</label>
                            <input class="form-control @error('file') is-invalid @enderror"
                                   id="file"
                                   type="file"
                                   name="file"
                                   value="{{ old('file') }}"
                                   required>

                            @error('file')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div><!-- /.form-group -->

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ __('Upload') }}</button>
                        </div>
                    </form>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
