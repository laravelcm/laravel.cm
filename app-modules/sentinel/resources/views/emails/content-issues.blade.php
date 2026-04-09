<x-mail::message>

<x-mail::panel>

{{ __('sentinel::notifications.greeting', ['name' => $user->name]) }}

{{ __('sentinel::notifications.intro', ['count' => $issues->count()]) }}

{{ __('sentinel::notifications.deadline', ['days' => $deadlineDays]) }}

</x-mail::panel>

@foreach ($issues as $issue)
@php
    $modelName = class_basename($issue->issueable_type);
    $model = $issue->issueable;
    $title = data_get($model, 'title', data_get($model, 'subject', '#' . $issue->issueable_id));
@endphp
- **{{ $modelName }}** "{{ $title }}" : {{ __('sentinel::notifications.types.' . $issue->type->value) }}
@endforeach

<x-mail::button :url="route('login')">
{{ __('sentinel::notifications.action') }}
</x-mail::button>

<p>
    Cordialement, <br>
    L'{{ config('app.name') }}
</p>

</x-mail::message>
