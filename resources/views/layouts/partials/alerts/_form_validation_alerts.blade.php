@if($errors->count())
    <div class="alert alert-danger alert-dismissible mb-3 fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <ul class="mb-0">
            @foreach($errors->keys() as $key)
                @foreach($errors->get($key) as $message)
                    <li>{{ $message }}</li>
                @endforeach
            @endforeach
        </ul>
    </div>
@endif
