@component('mail::message')
# Account Deactivated

Hello {{ $user->name }},

We are just letting you know your account was deactivated.

> If you didn't make these changes; Please contact [Support]({{ route('home') }}) immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
