@component('mail::message')
    Bonjour **{{ $user->name }}**, Vous recevez ce mail parce que vous avez créé votre compte sur Laravel DRC
    {{ $user->created_at->diffForHumans() }}, et à ce jour, vous n'avez pas encore vérifié votre adresse mail. Pour
    éviter toute suppression de votre compte il vous reste {{ $user->created_at->addDays(10)->diffInDays(now()) }}
    jour(s) pour valider votre adresse email.

    @component('mail::button', ['url' => route('verification.notice'), 'color' => 'green'])
        Renvoyer le lien
    @endcomponent

    Merci d'utiliser Laravel DRC,
    <br />
    {{ config('app.name') }}
@endcomponent
