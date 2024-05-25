@component('mail::message')
# Account Restored

Hello {{ $user->name }},

We are just letting you know your account is now restored.

@component('mail::button', ['url' => route('dashboard')])
Go to dashboard
@endcomponent

> If you didn't request this action; Please contact [Support]({{ route('home') }}) immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
