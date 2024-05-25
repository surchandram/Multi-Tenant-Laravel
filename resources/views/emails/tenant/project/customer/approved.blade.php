<x-mail.tenant-message :companyName="$company->name">
# Project Approval

Hi, thank you for approving our company to work on your property at __{{ $project->address->address_1 }}__.

Work is scheduled to begin on {{ $project->starts_at->format('Y-m-d H:i') }}.

<x-mail::button :url="$url">
View more details
</x-mail::button>

Thanks,<br>
{{ $company->name }}
</x-mail.tenant-message>
