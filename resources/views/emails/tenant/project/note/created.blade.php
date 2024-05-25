<x-mail::message>
# New Note Posted by {{ $message->user->name }}

A new note added for project at {{ sprintf('%s, %s, %s, %s', $project->address->address_1, $project->address->city, $project->address->state, $project->address->postal_code) }}.

<x-mail::button :url="$url">
View Project
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
