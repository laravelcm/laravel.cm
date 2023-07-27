@component('mail::message')

  Bonjour **{{ $user->name }}**,

  Bienvenue sur **Laravel Cameroun** ! La plus grande communauté de développeurs Laravel & PHP au Cameroun.

  Je sais que tu as un contenu génial à partager sur les médias sociaux. Et tu veux qu'il touche davantage de personnes et de développeurs de façon simple et rapide.

  [![Alt text](https://media.giphy.com/media/Sg4DwEJrCpGIU/giphy-downsized-large.gif)](https://laravel.cm/discussions/bienvenu-sur-laravel-cameroun)

  Je suis très heureux de te voir rejoindre Laravel Cameroun. Pour t'aider à démarrer, je veux partager avec toi les ressources de bases

  @component('mail::subcopy')
    [Créer un article :]({{ route('articles.new') }})
    partager vos connaissances en programmation avec plus de 200 développeurs de différentes nationalités qui ne demandent qu'à apprendre 🤩.
  @endcomponent

  @component('mail::subcopy')
    [Créer un thread :]({{ route('forum.new') }})
    vous rencontrez des soucis dans votre code ou votre projet 🤔 ? Partagez le avec nous et laissez nous vous aider.
  @endcomponent

  @component('mail::subcopy')
    [Démarrer une discussion :]({{ route('discussions.new') }})
    vous êtes du style bavard et vous avez des questions ? Partagez le avec nous et laissez nous vous aider. Nous sommes ici justement pour ça 😁
  @endcomponent

  ---

  Ou vous pouvez simplement commencer par dire bonjour aux autres membres de la communauté et vous présentez 👋🏾

  @component('mail::button', ['url' => 'https://laravel.cm/discussions/bienvenu-sur-laravel-cameroun', 'color' => 'green'])
    Dire bonjour à la communauté
  @endcomponent

  Arthur Monney et la Team [Laravel Cameroun]({{ route('about') }}).

@endcomponent
