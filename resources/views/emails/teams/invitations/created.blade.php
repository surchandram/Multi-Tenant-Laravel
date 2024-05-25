<x-mail::message>
# {{ __(':team team invitation', ['team' => $invitation->roleable->name]) }}

{{ $message }}

{{ __('If you do not have an account yet click the create account button below.') }}

{{ __('The invitation will be handled after your account is successfully created.') }}

<x-mail::button :url="$acceptUrl">
{{ __('Create Account') }}
</x-mail::button>

{{ __('If you already have an account click the button below to accept the invitation.') }}

<x-mail::button :url="$acceptUrlExisting">
{{ __('Accept Invitation') }}
</x-mail::button>

{{ __('If you do not wish to proceed, no further action is required.') }}

{{ __('Thanks,') }}<br>
{{ config('app.name') }}
</x-mail::message>
