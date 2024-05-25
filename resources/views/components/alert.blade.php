<div>
    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
        @isset($hint)<strong>{{ $hint }}</strong> @endisset
        {{ $message }}
        @if($link[0] ?? false)
            <a class="alert-link" href="{{ $link[0] }}">{{ $link[1] ?? $link[0] }}</a>
        @endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>