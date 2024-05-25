<x-mail.tenant-message :companyName="$company->name">
# Confirm Work Authorization and Schedule

Hi {{ $customerName }},

Please visit our customer portal to authorize and confirm schedule for work on your property at __{{ $project->address->address_1 }}__.

<x-mail::button :url="$url">
{{ __('customer.project.accept_invitation_button') }}
</x-mail::button>

Thanks,<br>
{{ $company->name }}
</x-mail.tenant-message>
