<x-mail::message>
# {{ __('tenant.project.status_mail.changed') }}

{{ __($project->currentStatus->mail(), ['address' => $project->address->formatted_address]) }}

<x-mail::button :url="$url">
{{ __('tenant.project.view_link_button') }}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
