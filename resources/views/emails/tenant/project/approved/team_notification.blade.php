<x-mail.tenant-message :companyName="$company->name">
# New Project Schedule

Hi, client has approved for work to begin at property on __{{ $project->address->address_1 }}__.

Work is scheduled to start on **{{ $project->starts_at->format('Y-m-d H:i') }}**.

<x-mail::button :url="$url">
{{ __('tenant.project.view_link_button') }}
</x-mail::button>

Thanks,<br>
{{ $company->name }}
</x-mail::message>
