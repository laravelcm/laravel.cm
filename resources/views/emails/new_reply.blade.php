@component('mail::message')
    <b>{{ '@' . $reply->user->username }}</b> a répondu à ce sujet.

    @component('mail::panel')
        {{ $reply->excerpt(200) }}
    @endcomponent

    @component('mail::button', ['url' => route('forum.show', $reply->replyAble->slug), 'color' => 'green'])
        Voir le sujet
    @endcomponent

    @component('mail::subcopy')
            Vous recevez ceci parce que vous êtes abonné à ce sujet. [Se désabonner]({{ \Illuminate\Support\Facades\URL::temporarySignedRoute('subscriptions.unsubscribe', now()->addMonths(6), ['subscription' => $subscription->uuid()->toString()]) }}) de ce sujet.
    @endcomponent
@endcomponent
