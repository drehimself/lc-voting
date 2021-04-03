@component('mail::message')
# Idea Status Updated

The idea: {{ $idea->title }}

has been updated to a status of:

{{ $idea->status->name }}

@component('mail::button', ['url' => route('idea.show', $idea)])
View Idea
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
