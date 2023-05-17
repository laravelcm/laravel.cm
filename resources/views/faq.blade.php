@title(__('FAQ'))

@extends('layouts.default')

@section('body')

    <div class="mb-14">
        <h2 class="text-3xl font-extrabold font-heading text-skin-inverted lg:text-4xl">
            {{ __('Foire aux questions 🤔') }}
        </h2>
        <p class="mt-2 text-sm text-skin-muted font-normal lg:text-base">{{ __("Certaines d'entre elles ne sont pas demandées fréquemment, mais elles sont toujours bonnes à savoir.") }}</p>
    </div>

    <div id="faq-questions" class="text-base flex -mx-2 -mt-4">
        <div class="flex-none px-2 w-full md:hidden">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">{{ __('Qui peut publier des articles/sujets sur Laravel.cm?') }}</h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Les modérateurs ! Oui, vous avez la permission de publier un nouvel article, quel qu'il soit, du moment qu'il
                        respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.
                    </p>
                    <p>
                        Votre article peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre
                        <a href="{{ route('rules') }}">code de conduite</a>.
                    </p>
                    <p>
                        Mais après validation votre article peut être rendu public sur le fil d'actualité de la communauté et envoyé en notification
                        sur le compte Twitter de la communauté.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Qui peut publier sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Tout le monde ! Oui, vous avez la permission de publier un nouveau contenu, quel qu'il soit, du moment qu'il
                        respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.
                    </p>
                    <p>
                        Votre contenu peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences
                        de notre <a href="{{ route('rules') }}">code de conduite</a>.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Ou puis-je retrouver la communauté?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>La communauté est présente sur Twitter, Github, LinkedIn, Facebook et YouTube. Tous les liens sont disponibles dans le pied de page.</p>
                    <p>
                        Mais pour les canaux de communication, le principal canal de communication et d'échange avec les membres de la communauté
                        reste le groupe <a href="{{ route('slack') }}">Slack</a>. Vous pouvez rejoindre slack en vous rendant sur cette <a href="{{ route('slack') }}">page</a>.
                    </p>
                    <p>
                        Mais la communauté dispose aussi d'un groupe <a href="{{ route('telegram') }}">Telegram</a> et d'un groupe WhatsApp
                        (limite par les règles de gestion de groupe de WhatsApp) qui sont accessibles par tous.
                    </p>
                    <p>Ceci dit, nous recommandons plus de rejoindre le groupe Slack.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment se passe le sponsoring sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>Le sponsoring sur Laravel.cm est une opportunité pour gagner en visibilité et de mettre votre contenu en avant sur le site.</p>
                    <p>
                        Visitez la page de <a href="{{ route('sponsors') }}">Sponsoring</a> pour avoir toutes les informations
                        (par exemple comment ça marche, comment être sponsor de la communauté, pourquoi sponsoriser son contenu, etc).
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Puis-je participer à un podcast?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>Bien sûr ! Les podcasts seront ouverts à tous et tout le monde aura l'occasion de participer.</p>
                    <p>La communauté se veut ouverte et ne pas couvrir que le sujet de la programmation.</p>
                    <p>
                        De ce fait plusieurs autres thématiques seront partagées pour donner la possibilité à tout le monde
                        de partager son experience autour d'un micro.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment changer mon nom d'utilisateur Twitter/GitHub ?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Vous pouvez ajouter ou supprimer des associations Twitter/GitHub de vos paramètres, mais notez que vous ne pouvez
                        le faire que si Twitter et GitHub sont connectés à votre compte. Si vous rencontrez des problèmes avec cela,
                        envoyez un e-mail à <a href="mailto:support@laravel.cm">support@laravel.cm</a> et nous nous en occuperons.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment devenir Premium?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Devenir premium sur Laravel.cm, c'est soutenir la création de nouveaux contenus et accéder à du contenu
                        exclusif pour apprendre et s'améliorer (comme le téléchargement des vidéos des sources, et des designs).
                    </p>
                    <p>Pour être premium, vous devez aller sur la page pour <a href="#">Devenir premium</a> et choisir un abonnement.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Existe-t-il un guide sur l'utilisation de l'éditeur Markdown?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Oui! Laravel.cm utilise Markdown X réalisé par <a href="https://twitter.com/tnylea">Tony Lea</a> sur la plateforme
                        <a href="https://devdojo.com">DevDojo</a>.
                    </p>
                    <p>
                        Vous pouvez le trouver en cliquant sur le bouton Aide dans la page de l'éditeur.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment supprimer mon compte ?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Vous trouverez la possibilité de supprimer votre compte dans vos paramètres. L'auto-suppression supprimera
                        votre profil sur Laravel.cm, ainsi que tous les articles, commentaires, discussions, sujets, etc.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Quelles technologies utilisées Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Laravel.cm est basé sur le framework Laravel et implémente le <a href="https://tallstack.dev">TALL Stack</a> qui permet de
                        créer des applications réactives sur Laravel avec Livewire et Alpinejs.
                    </p>
                    <p>C'est un preset de développement full-stack, construite par les membres de la communauté Laravel.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment signaler un abus?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>Pour un commentaire spécifique : accédez au commentaire et cliquez sur la flèche déroulante pour signaler un abus.</p>
                    <p>Pour un article spécifique : accédez à l'article, faites défiler vers le bas et cliquez sur signaler un abus.</p>
                    <p>En général, vous pouvez faire un mail à <a href="mailto:support@laravel.cm">support@laravel.cm</a> </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Puis-je suivre les Flux RSS sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Oui, vous pouvez. Le lien de notre flux principal se trouve ici : <a href="{{ config('app.url') }}/feed">{{ config('app.url') }}/feed</a>.
                        Pour les flux spécifiques aux utilisateurs, vous pouvez les trouver via https://laravel.cm/feed/username.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Puis-je poster ou trouver un job sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Oui! La communauté servira aussi pour les entreprises à poster des offres et à recruter des talents,
                        freelances, stagiaires pour des missions, contrats, etc.
                    </p>
                    <p>
                        Laravel.cm veut pouvoir mettre en avant les développeurs de la zone francophones en avant sur différentes
                        offres qui pourront être partagé de partout l'Afrique et du monde en général.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/2 hidden md:block lg:hidden">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Qui peut publier sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Tout le monde ! Oui, vous avez la permission de publier un nouveau contenu, quel qu'il soit,
                        du moment qu'il respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.
                    </p>
                    <p>
                        Votre contenu peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas
                        aux exigences de notre <a href="{{ route('rules') }}">code de conduite</a>.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Ou puis-je retrouver la communauté?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>La communauté est présente sur Twitter, Github, LinkedIn, Facebook et YouTube. Tous les liens sont disponibles dans le pied de page.</p>
                    <p>
                        Mais pour les canaux de communication, le principal canal de communication et d'échange avec les membres de la communauté
                        reste le groupe <a href="{{ route('slack') }}">Slack</a>.
                        Vous pouvez rejoindre slack en vous rendant sur cette <a href="{{ route('slack') }}">page</a>.
                    </p>
                    <p>
                        Mais la communauté dispose aussi d'un groupe <a href="{{ route('telegram') }}">Telegram</a> et d'un groupe WhatsApp
                        (limite par les règles de gestion de groupe de WhatsApp) qui sont accessibles par tous.
                    </p>
                    <p>Ceci dit, nous recommandons plus de rejoindre le groupe Slack.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment se passe le sponsoring sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>Le sponsoring sur Laravel.cm est une opportunité pour gagner en visibilité et de mettre votre contenu en avant sur le site.</p>
                    <p>
                        Visitez la page de <a href="{{ route('sponsors') }}">Sponsoring</a> pour avoir toutes les informations
                        (par exemple comment ça marche, comment être sponsor de la communauté, pourquoi sponsoriser son contenu, etc).
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Puis-je participer à un podcast?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>Bien sûr ! Les podcasts seront ouverts à tous et tout le monde aura l'occasion de participer.</p>
                    <p>La communauté se veut ouverte et ne pas couvrir que le sujet de la programmation.</p>
                    <p>
                        De ce fait plusieurs autres thématiques seront partagées pour donner la possibilité à tout le monde
                        de partager son experience autour d'un micro.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment changer mon nom d'utilisateur Twitter/GitHub ?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Vous pouvez ajouter ou supprimer des associations Twitter/GitHub de vos paramètres,
                        mais notez que vous ne pouvez le faire que si Twitter et GitHub sont connectés à votre compte.
                        Si vous rencontrez des problèmes avec cela, envoyez un e-mail à <a href="mailto:support@laravel.cm">support@laravel.cm</a>
                        et nous nous en occuperons.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment devenir Premium?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Devenir premium sur Laravel.cm, c'est soutenir la création de nouveaux contenus et accéder à du contenu exclusif
                        pour apprendre et s'améliorer (comme le téléchargement des vidéos des sources, et des designs).
                    </p>
                    <p>Pour être premium, vous devez aller sur la page pour <a href="#">Devenir premium</a> et choisir un abonnement.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Existe-t-il un guide sur l'utilisation de l'éditeur Markdown?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Oui! Laravel.cm utilise Markdown X réalisé par <a href="https://twitter.com/tnylea">Tony Lea</a> sur la plateforme
                        <a href="https://devdojo.com">DevDojo</a>.
                    </p>
                    <p>Vous pouvez le trouver en cliquant sur le bouton Aide dans la page de l'éditeur.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/2 hidden md:block lg:hidden">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    {{ __('Qui peut publier des articles/sujets sur Laravel.cm?') }}
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Les modérateurs ! Oui, vous avez la permission de publier un nouvel article, quel qu'il soit, du moment qu'il
                        respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.
                    </p>
                    <p>
                        Votre article peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre
                        <a href="{{ route('rules') }}">code de conduite</a>.
                    </p>
                    <p>
                        Mais après validation votre article peut être rendu public sur le fil d'actualité de la communauté et envoyé en notification sur le compte Twitter de la communauté.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment supprimer mon compte ?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Vous trouverez la possibilité de supprimer votre compte dans vos paramètres. L'auto-suppression supprimera
                        votre profil sur Laravel.cm, ainsi que tous les articles, commentaires, discussions, sujets, etc.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">Quelles technologies utilisées Laravel.cm?</h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Laravel.cm est basé sur le framework Laravel et implémente le <a href="https://tallstack.dev">TALL Stack</a> qui permet
                        de créer des applications réactives sur Laravel avec Livewire et Alpinejs.
                    </p>
                    <p>C'est un preset de développement full-stack, construite par les membres de la communauté Laravel.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment signaler un abus?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>Pour un commentaire spécifique : accédez au commentaire et cliquez sur la flèche déroulante pour signaler un abus.</p>
                    <p>Pour un article spécifique : accédez à l'article, faites défiler vers le bas et cliquez sur signaler un abus.</p>
                    <p>
                        En général, vous pouvez remplir le <a href="#">formulaire</a> de signalement d'abus, ou tout simplement faire un mail à
                        <a href="mailto:support@laravel.cm">support@laravel.cm</a>
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Puis-je suivre les Flux RSS sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Oui, vous pouvez. Le lien de notre flux principal se trouve ici : <a href="{{ config('app.url') }}/feed">{{ config('app.url') }}/feed</a>.
                        Pour les flux spécifiques aux utilisateurs, vous pouvez les trouver via https://laravel.cm/feed/username.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Puis-je poster ou trouver un job sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Oui! La communauté servira aussi pour les entreprises à poster des offres et à recruter des talents,
                        freelances, stagiaires pour des missions, contrats, etc.
                    </p>
                    <p>
                        Laravel.cm veut pouvoir mettre en avant les développeurs de la zone francophones en avant sur différentes
                        offres qui pourront être partagé de partout l'Afrique et du monde en général.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/3 hidden lg:block">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Qui peut publier sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Tout le monde ! Oui, vous avez la permission de publier un nouveau contenu, quel qu'il soit,
                        du moment qu'il respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.
                    </p>
                    <p>
                        Votre contenu peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences
                        de notre <a href="{{ route('rules') }}">code de conduite</a>.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Ou puis-je retrouver la communauté?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>La communauté est présente sur Twitter, Github, LinkedIn, Facebook et YouTube. Tous les liens sont disponibles dans le pied de page.</p>
                    <p>
                        Mais pour les canaux de communication, le principal canal de communication et d'échange avec les membres de la communauté reste le groupe <a href="{{ route('slack') }}">Slack</a>.
                        Vous pouvez rejoindre slack en vous rendant sur cette <a href="{{ route('slack') }}">page</a>.
                    </p>
                    <p>
                        Mais la communauté dispose aussi d'un groupe <a href="{{ route('telegram') }}">Telegram</a> et d'un groupe WhatsApp
                        (limite par les règles de gestion de groupe de WhatsApp) qui sont accessibles par tous.
                    </p>
                    <p>Ceci dit nous, recommandons plus de rejoindre le groupe Slack.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment se passe le sponsoring sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>Le sponsoring sur Laravel.cm est une opportunité pour gagner en visibilité et de mettre votre contenu en avant sur le site.</p>
                    <p>
                        Visitez la page de <a href="{{ route('sponsors') }}">Sponsoring</a> pour avoir toutes les informations
                        (par exemple comment ça marche, comment être sponsor de la communauté, pourquoi sponsoriser son contenu, etc).
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Puis-je participer à un podcast?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>Bien sûr ! Les podcasts seront ouverts à tous et tout le monde aura l'occasion de participer.</p>
                    <p>La communauté se veut ouverte et ne pas couvrir que le sujet de la programmation.</p>
                    <p>
                        De ce fait plusieurs autres thématiques seront partagées pour donner la possibilité à tout le monde
                        de partager son experience autour d'un micro.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/3 hidden lg:block">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment changer mon nom d'utilisateur Twitter/GitHub ?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Vous pouvez ajouter ou supprimer des associations Twitter/GitHub de vos paramètres, mais notez que vous
                        ne pouvez le faire que si Twitter et GitHub sont connectés à votre compte. Si vous rencontrez des problèmes
                        avec cela, envoyez un e-mail à <a href="mailto:support@laravel.cm">support@laravel.cm</a> et nous nous en occuperons.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment devenir Premium?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Devenir premium sur Laravel.cm, c'est soutenir la création de nouveaux contenus et accéder à du contenu exclusif
                        pour apprendre et s'améliorer (comme le téléchargement des vidéos des sources, et des designs).
                    </p>
                    <p>Pour être premium, vous devez aller sur la page pour <a href="#">Devenir premium</a> et choisir un abonnement.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Existe-t-il un guide sur l'utilisation de l'éditeur Markdown?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Oui! Laravel.cm utilise Markdown X réalisé par <a href="https://twitter.com/tnylea">Tony Lea</a> sur la plateforme
                        <a href="https://devdojo.com">DevDojo</a>.
                    </p>
                    <p>Vous pouvez le trouver en cliquant sur le bouton Aide dans la page de l'éditeur.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment supprimer mon compte ?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Vous trouverez la possibilité de supprimer votre compte dans vos paramètres. L'auto-suppression supprimera
                        votre profil sur Laravel.cm, ainsi que tous les articles, commentaires, discussions, sujets, etc.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Quelles technologies utilisées Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Laravel.cm est basé sur le framework Laravel et implémente le <a href="https://tallstack.dev">TALL Stack</a> qui permet de créer
                        des applications réactives sur Laravel avec Livewire et Alpinejs.
                    </p>
                    <p>C'est un preset de développement full-stack, construite par les membres de la communauté Laravel.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/3 hidden lg:block">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    {{ __('Qui peut publier des articles/sujets sur Laravel.cm?') }}
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Les modérateurs ! Oui, vous avez la permission de publier un nouvel article, quel qu'il soit, du moment qu'il respecte
                        les directives de notre communauté et passe par les filtres anti-spam de bon sens.
                    </p>
                    <p>
                        Votre article peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences
                        de notre <a href="{{ route('rules') }}">code de conduite</a>.
                    </p>
                    <p>
                        Mais après validation votre article peut être rendu public sur le fil d'actualité de la communauté et
                        envoyé en notification sur le compte Twitter de la communauté.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Comment signaler un abus ?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>Pour un commentaire spécifique : accédez au commentaire et cliquez sur la flèche déroulante pour signaler un abus.</p>
                    <p>Pour un article spécifique : accédez à l'article, faites défiler vers le bas et cliquez sur signaler un abus.</p>
                    <p>En général, vous pouvez faire un mail à <a href="mailto:support@laravel.cm">support@laravel.cm</a> </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Puis-je suivre les Flux RSS sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Oui, vous pouvez. Le lien de notre flux principal se trouve ici : <a href="{{ config('app.url') }}/feed">{{ config('app.url') }}/feed</a>.
                        Pour les flux spécifiques aux utilisateurs, vous pouvez les trouver via https://laravel.cm/feed/username.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-heading mb-2">
                    Puis-je poster ou trouver un job sur Laravel.cm?
                </h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Oui! La communauté servira aussi pour les entreprises à poster des offres et à recruter des talents, freelances,
                        stagiaires pour des missions, contrats, etc.
                    </p>
                    <p>
                        Laravel.cm veut pouvoir mettre en avant les développeurs de la zone francophones en avant sur différentes
                        offres qui pourront être partagé de partout l'Afrique et du monde en général.
                    </p>
                </div>
            </div>
        </div>
    </div>

@stop
