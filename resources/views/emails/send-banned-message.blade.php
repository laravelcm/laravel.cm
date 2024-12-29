<x-mail::message>

<x-mail::panel>

Chèr(e) {{ $user->name }},

Nous vous informons que votre compte sur Laravel DRC a été suspendu en raison de non-respect de nos conditions d'utilisation.

**Raison du bannissement :**
{{ $user->banned_reason }}

Veuillez noter que pendant la durée de votre bannissement, vous ne pourrez pas accéder à votre compte ni aux services offerts par notre plateforme.

Si vous pensez que cette suspension est une erreur ou que vous souhaitez obtenir plus d'informations, n'hésitez pas à nous contacter.

</x-mail::panel>

<p>
    Cordialement,  <br>
    L'équipe Laravel DRC
</p>

</x-mail::message>
