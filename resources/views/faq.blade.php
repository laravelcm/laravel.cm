@title(__('FAQ'))

@extends('layouts.default')

@section('body')

    <div class="mb-14">
        <h2 class="text-3xl font-extrabold text-skin-inverted lg:text-4xl font-sans">
            {{ __('Foire aux questions 🤔') }}
        </h2>
        <p class="mt-2 text-sm text-skin-muted font-normal lg:text-base">{{ __("Certaines d'entre elles ne sont pas demandées fréquemment, mais elles sont toujours bonnes à savoir.") }}</p>
    </div>

    <div id="faq-questions" class="text-base flex -mx-2 -mt-4">
        <div class="flex-none px-2 w-full md:hidden">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">{{ __('Qui peut publier des articles/sujets sur Laravel.cm?') }}</h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Les modérateurs! Oui, vous avez la permission de publier un nouvel article, quel qu'il soit, du moment qu'il
                        respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.
                    </p>
                    <p>
                        Votre article peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre
                        <a href="{{ route('rules') }}">code de conduite</a>.
                    </p>
                    <p>
                        Mais apres validation votre article peut-etre rendu public sur le fil d'actualite de la communaute et envoye en notification sur le compte Twitter de la communaute.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Qui peut publier sur Laravel.cm?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Tout le monde! Oui, vous avez la permission de publier un nouveau contenu, quel qu'il soit, du moment qu'il respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.</p>
                    <p>Votre contenu peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre <a href="{{ route('rules') }}">code de conduite</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Ou puis-je retrouver la communauté?</h3>
                <div class="prose prose-sm leading-5">
                    <p>La communauté est présente sur Twitter, Github, LinkedIn, Facebook et YouTube. Tous les liens sont disponibles dans le pied de page.</p>
                    <p>Mais pour les canneaux de communication, le principal canal de communication et d'échange avec les membres de la communauté reste le groupe <a href="{{ route('slack') }}">Slack</a>. Vous pouvez rejoindre slack en vous rendant sur cette <a href="#">page</a>.</p>
                    <p>Mais la communauté dispose aussi d'un groupe <a href="{{ route('telegram') }}">Telegram</a> et d'un groupe WhatsApp (limite par les règles de gestion de groupe de WhatsApp) qui sont accessible par tous.</p>
                    <p>Ceci dit nous recommandons plus de rejoindre le groupe Slack.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What version of Tailwind CSS is used?</h3>
                <div class="prose prose-sm leading-5"><p>The components in Tailwind UI are authored using Tailwind CSS v2.0.</p>
                    <p>Learn more about this in our <a href="/documentation">getting started documentation</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "free updates" include?</h3>
                <div class="prose prose-sm leading-5"><p>We regularly add new Marketing and Application UI components whenever we have new ideas and all new components added to those categories will be always be totally free for existing customers.</p>
                    <p>To see what our previous updates have looked like, <a href="/changelog">check out our changelog</a>.</p>
                    <p>We do plan to work on new component kits in the future that will be sold separately (email templates and e-commerce are ideas we've tossed around), but any components we design and build that belong in an existing kit will always be added as a free update.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Comment changer mon nom d'utilisateur Twitter/GitHub ?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Vous pouvez ajouter ou supprimer des associations Twitter/GitHub de vos paramètres, mais notez que vous ne pouvez le faire que si Twitter et GitHub sont connectés à votre compte. Si vous rencontrez des problèmes avec cela, envoyez un e-mail à <a href="mailto:support@laravel.cm">support@laravel.cm</a> et nous nous en occuperons.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Comment devenir Premium?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Devenir premium sur Laravel.cm, c'est soutenir la création de nouveaux contenus et accéder à du contenu exclusif pour apprendre et s'améliorer (comme le téléchargement des vidéos des sources, et des designs).</p>
                    <p>Pour etre premium vous devez aller sur la page pour <a href="#">Devenir premiun</a> et choisir un abonnement.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Existe-t-il un guide sur l'utilisation de l'éditeur Markdown?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Oui! Laravel.cm utilise Markdown X réalisé par <a href="https://twitter.com/tnylea">Tony Lea</a> sur la plateforme <a href="https://devdojo.com">DevDojo</a>.</p>
                    <p>Voici notre <a href="#">guide de l'éditeur</a>, vous pouvez également le trouver en cliquant sur le bouton Aide dans page de l'éditeur.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "unlimited projects" mean?</h3>
                <div class="prose prose-sm leading-5"><p>Unlike most other templates/themes, you don't have to buy a new Tailwind UI license every time you want to use it on a new project.</p>
                    <p>As long as what you're building will be owned by the Tailwind UI license holder, you can build as many sites as you want without ever having to buy an additional license.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI for client projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yes! You can use Tailwind UI for basically anything — the only thing we disallow is using it to create derivative competing products.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Comment signaler un spam ?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Pour un commentaire spécifique : accédez au commentaire et cliquez sur la flèche déroulante pour signaler un abus.</p>
                    <p>Pour un article spécifique : accédez à l'article, faites défiler vers le bas et cliquez sur signaler un abus.</p>
                    <p>En général, vous pouvez remplir le <a href="#">formulaire</a> de signalement d'abus, ou tout simplement faire un mail à <a href="mailto:support@laravel.cm">support@laravel.cm</a> </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI in open source projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yep! As long as what you're building is some sort of actual website and not a derivative component library, theme builder, or other product where the primary purpose is clearly to repackage and redistribute our components, it's totally okay for that project to be open source.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I sell templates/themes I build with Tailwind UI?</h3>
                <div class="prose prose-sm leading-5"><p>No, you cannot use Tailwind UI to create derivative products like themes, UI kits, page builders, or anything else where you would be repackaging and redistributing our components for someone else to use to build their own sites.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What is your refund policy?</h3>
                <div class="prose prose-sm leading-5"><p>If you're unhappy with your purchase for any reason, email us at <a href="mailto:support@tailwindui.com">support@tailwindui.com</a> within 90 days and we'll refund you in full, no questions asked.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/2 hidden md:block lg:hidden">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Qui peut publier sur Laravel.cm?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Tout le monde! Oui, vous avez la permission de publier un nouveau contenu, quel qu'il soit, du moment qu'il respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.</p>
                    <p>Votre contenu peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre <a href="{{ route('rules') }}">code de conduite</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Ou puis-je retrouver la communauté?</h3>
                <div class="prose prose-sm leading-5">
                    <p>La communauté est présente sur Twitter, Github, LinkedIn, Facebook et YouTube. Tous les liens sont disponibles dans le pied de page.</p>
                    <p>Mais pour les canneaux de communication, le principal canal de communication et d'échange avec les membres de la communauté reste le groupe <a href="{{ route('slack') }}">Slack</a>. Vous pouvez rejoindre slack en vous rendant sur cette <a href="#">page</a>.</p>
                    <p>Mais la communauté dispose aussi d'un groupe <a href="{{ route('telegram') }}">Telegram</a>et d'un groupe WhatsApp (limite par les règles de gestion de groupe de WhatsApp) qui sont accessible par tous.</p>
                    <p>Ceci dit nous recommandons plus de rejoindre le groupe Slack.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What version of Tailwind CSS is used?</h3>
                <div class="prose prose-sm leading-5"><p>The components in Tailwind UI are authored using Tailwind CSS v2.0.</p>
                    <p>Learn more about this in our <a href="/documentation">getting started documentation</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "free updates" include?</h3>
                <div class="prose prose-sm leading-5"><p>We regularly add new Marketing and Application UI components whenever we have new ideas and all new components added to those categories will be always be totally free for existing customers.</p>
                    <p>To see what our previous updates have looked like, <a href="/changelog">check out our changelog</a>.</p>
                    <p>We do plan to work on new component kits in the future that will be sold separately (email templates and e-commerce are ideas we've tossed around), but any components we design and build that belong in an existing kit will always be added as a free update.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Comment changer mon nom d'utilisateur Twitter/GitHub ?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Vous pouvez ajouter ou supprimer des associations Twitter/GitHub de vos paramètres, mais notez que vous ne pouvez le faire que si Twitter et GitHub sont connectés à votre compte. Si vous rencontrez des problèmes avec cela, envoyez un e-mail à <a href="mailto:support@laravel.cm">support@laravel.cm</a> et nous nous en occuperons.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Comment devenir Premium?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Devenir premium sur Laravel.cm, c'est soutenir la création de nouveaux contenus et accéder à du contenu exclusif pour apprendre et s'améliorer (comme le téléchargement des vidéos des sources, et des designs).</p>
                    <p>Pour etre premium vous devez aller sur la page pour <a href="#">Devenir premiun</a> et choisir un abonnement.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Existe-t-il un guide sur l'utilisation de l'éditeur Markdown?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Oui! Laravel.cm utilise Markdown X réalisé par <a href="https://twitter.com/tnylea">Tony Lea</a> sur la plateforme <a href="https://devdojo.com">DevDojo</a>.</p>
                    <p>Voici notre <a href="#">guide de l'éditeur</a>, vous pouvez également le trouver en cliquant sur le bouton Aide dans page de l'éditeur.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/2 hidden md:block lg:hidden">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">{{ __('Qui peut publier des articles/sujets sur Laravel.cm?') }}</h3>
                <div class="prose prose-sm leading-5">
                    <p>
                        Les modérateurs! Oui, vous avez la permission de publier un nouvel article, quel qu'il soit, du moment qu'il
                        respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.
                    </p>
                    <p>
                        Votre article peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre
                        <a href="{{ route('rules') }}">code de conduite</a>.
                    </p>
                    <p>
                        Mais apres validation votre article peut-etre rendu public sur le fil d'actualite de la communaute et envoye en notification sur le compte Twitter de la communaute.
                    </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "unlimited projects" mean?</h3>
                <div class="prose prose-sm leading-5"><p>Unlike most other templates/themes, you don't have to buy a new Tailwind UI license every time you want to use it on a new project.</p>
                    <p>As long as what you're building will be owned by the Tailwind UI license holder, you can build as many sites as you want without ever having to buy an additional license.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI for client projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yes! You can use Tailwind UI for basically anything — the only thing we disallow is using it to create derivative competing products.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Comment signaler un spam ?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Pour un commentaire spécifique : accédez au commentaire et cliquez sur la flèche déroulante pour signaler un abus.</p>
                    <p>Pour un article spécifique : accédez à l'article, faites défiler vers le bas et cliquez sur signaler un abus.</p>
                    <p>En général, vous pouvez remplir le <a href="#">formulaire</a> de signalement d'abus, ou tout simplement faire un mail à <a href="mailto:support@laravel.cm">support@laravel.cm</a> </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI in open source projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yep! As long as what you're building is some sort of actual website and not a derivative component library, theme builder, or other product where the primary purpose is clearly to repackage and redistribute our components, it's totally okay for that project to be open source.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I sell templates/themes I build with Tailwind UI?</h3>
                <div class="prose prose-sm leading-5"><p>No, you cannot use Tailwind UI to create derivative products like themes, UI kits, page builders, or anything else where you would be repackaging and redistributing our components for someone else to use to build their own sites.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What is your refund policy?</h3>
                <div class="prose prose-sm leading-5"><p>If you're unhappy with your purchase for any reason, email us at <a href="mailto:support@tailwindui.com">support@tailwindui.com</a> within 90 days and we'll refund you in full, no questions asked.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/3 hidden lg:block">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Qui peut publier sur Laravel.cm?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Tout le monde! Oui, vous avez la permission de publier un nouveau contenu, quel qu'il soit, du moment qu'il respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.</p>
                    <p>Votre contenu peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre <a href="{{ route('rules') }}">code de conduite</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Ou puis-je retrouver la communauté?</h3>
                <div class="prose prose-sm leading-5">
                    <p>La communauté est présente sur Twitter, Github, LinkedIn, Facebook et YouTube. Tous les liens sont disponibles dans le pied de page.</p>
                    <p>Mais pour les canneaux de communication, le principal canal de communication et d'échange avec les membres de la communauté reste le groupe <a href="{{ route('slack') }}">Slack</a>. Vous pouvez rejoindre slack en vous rendant sur cette <a href="#">page</a>.</p>
                    <p>Mais la communauté dispose aussi d'un groupe <a href="{{ route('telegram') }}">Telegram</a> et d'un groupe WhatsApp (limite par les règles de gestion de groupe de WhatsApp) qui sont accessible par tous.</p>
                    <p>Ceci dit nous recommandons plus de rejoindre le groupe Slack.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What version of Tailwind CSS is used?</h3>
                <div class="prose prose-sm leading-5"><p>The components in Tailwind UI are authored using Tailwind CSS v2.0.</p>
                    <p>Learn more about this in our <a href="/documentation">getting started documentation</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "free updates" include?</h3>
                <div class="prose prose-sm leading-5"><p>We regularly add new Marketing and Application UI components whenever we have new ideas and all new components added to those categories will be always be totally free for existing customers.</p>
                    <p>To see what our previous updates have looked like, <a href="/changelog">check out our changelog</a>.</p>
                    <p>We do plan to work on new component kits in the future that will be sold separately (email templates and e-commerce are ideas we've tossed around), but any components we design and build that belong in an existing kit will always be added as a free update.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/3 hidden lg:block">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Comment changer mon nom d'utilisateur Twitter/GitHub ?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Vous pouvez ajouter ou supprimer des associations Twitter/GitHub de vos paramètres, mais notez que vous ne pouvez le faire que si Twitter et GitHub sont connectés à votre compte. Si vous rencontrez des problèmes avec cela, envoyez un e-mail à <a href="mailto:support@laravel.cm">support@laravel.cm</a> et nous nous en occuperons.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Comment devenir Premium?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Devenir premium sur Laravel.cm, c'est soutenir la création de nouveaux contenus et accéder à du contenu exclusif pour apprendre et s'améliorer (comme le téléchargement des vidéos des sources, et des designs).</p>
                    <p>Pour etre premium vous devez aller sur la page pour <a href="#">Devenir premiun</a> et choisir un abonnement.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Existe-t-il un guide sur l'utilisation de l'éditeur Markdown?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Oui! Laravel.cm utilise Markdown X réalisé par <a href="https://twitter.com/tnylea">Tony Lea</a> sur la plateforme <a href="https://devdojo.com">DevDojo</a>.</p>
                    <p>Voici notre <a href="#">guide de l'éditeur</a>, vous pouvez également le trouver en cliquant sur le bouton Aide dans page de l'éditeur.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What does "unlimited projects" mean?</h3>
                <div class="prose prose-sm leading-5"><p>Unlike most other templates/themes, you don't have to buy a new Tailwind UI license every time you want to use it on a new project.</p>
                    <p>As long as what you're building will be owned by the Tailwind UI license holder, you can build as many sites as you want without ever having to buy an additional license.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI for client projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yes! You can use Tailwind UI for basically anything — the only thing we disallow is using it to create derivative competing products.</p>
                    <p>For more information and examples, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
        </div>

        <div class="flex-none px-2 w-1/3 hidden lg:block">
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">{{ __('Qui peut publier des articles/sujets sur Laravel.cm?') }}</h3>
                <div class="prose prose-sm leading-5">
                    <p>Les modérateurs! Oui, vous avez la permission de publier un nouvel article, quel qu'il soit, du moment qu'il respecte les directives de notre communauté et passe par les filtres anti-spam de bon sens.</p>
                    <p>Votre article peut être supprimé à la discrétion des modérateurs s'ils estiment qu'il ne répond pas aux exigences de notre <a href="{{ route('rules') }}">code de conduite</a>.</p>
                    <p>Mais apres validation votre article peut-etre rendu public sur le fil d'actualite de la communaute et envoye en notification sur le compte Twitter de la communaute.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Comment signaler un spam ?</h3>
                <div class="prose prose-sm leading-5">
                    <p>Pour un commentaire spécifique : accédez au commentaire et cliquez sur la flèche déroulante pour signaler un abus.</p>
                    <p>Pour un article spécifique : accédez à l'article, faites défiler vers le bas et cliquez sur signaler un abus.</p>
                    <p>En général, vous pouvez remplir le <a href="#">formulaire</a> de signalement d'abus, ou tout simplement faire un mail à <a href="mailto:support@laravel.cm">support@laravel.cm</a> </p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I use Tailwind UI in open source projects?</h3>
                <div class="prose prose-sm leading-5"><p>Yep! As long as what you're building is some sort of actual website and not a derivative component library, theme builder, or other product where the primary purpose is clearly to repackage and redistribute our components, it's totally okay for that project to be open source.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">Can I sell templates/themes I build with Tailwind UI?</h3>
                <div class="prose prose-sm leading-5"><p>No, you cannot use Tailwind UI to create derivative products like themes, UI kits, page builders, or anything else where you would be repackaging and redistributing our components for someone else to use to build their own sites.</p>
                    <p>For more information and examples of what is and isn't okay, <a href="/license">read through our license</a>.</p>
                </div>
            </div>
            <div class="bg-skin-card p-6 rounded-md mt-4">
                <h3 class="font-semibold text-skin-inverted font-sans mb-2">What is your refund policy?</h3>
                <div class="prose prose-sm leading-5"><p>If you're unhappy with your purchase for any reason, email us at <a href="mailto:support@tailwindui.com">support@tailwindui.com</a> within 90 days and we'll refund you in full, no questions asked.</p>
                </div>
            </div>
        </div>
    </div>

@stop
