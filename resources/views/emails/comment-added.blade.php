@component('mail::message')
# A comment was posted on your idea

{{ $comment->user->name }} commented on your idea:

**{{ $comment->idea->title }}**

Comment: {{ $comment->body }}

@component('mail::button', ['url' => route('idea.show', $comment->idea)])
Go to Idea
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
