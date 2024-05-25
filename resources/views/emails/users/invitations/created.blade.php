<x-mail::message>
# {{ __('Registration invitation') }}

{{ $message }}

<x-mail::button :url="$acceptUrl">
{{ __('Accept Invitation') }}
</x-mail::button>

{{ __('If you do not wish to proceed, no further action is required.') }}

{{ __('Thanks,') }}<br>
{{ config('app.name') }}
</x-mail::message>
