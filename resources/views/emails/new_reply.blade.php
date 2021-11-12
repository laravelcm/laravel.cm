@component('mail::message')

    **{{ '@' . $reply->author->username }}** a répondu à ce sujet.

    @component('mail::panel')
        {{ $reply->excerpt(200) }}
    @endcomponent

    @component('mail::button', ['url' => route('forum.show', $reply->replyAble->slug())])
        Voir le sujet
    @endcomponent

    @component('mail::subcopy')
        Vous recevez ceci parce que vous êtes abonné à ce sujet.
        [Se désabonner]({{ route('subscriptions.unsubscribe', $subscription->uuid()->toString()) }}) from this thread.
    @endcomponent

@endcomponent
