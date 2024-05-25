@component('mail::message')
# Password Updated

Hello {{ $user->name }},

We are just letting you know your password was updated.

@component('mail::button', ['url' => route('dashboard')])
Go to dashboard
@endcomponent

> If you didn't make these changes; Please contact [Support]({{ route('home') }}) immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
