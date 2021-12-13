@title(__('Code de conduite'))

@extends('layouts.default')

@section('body')

    <div class="relative max-w-3xl mx-auto px-4 py-10 prose">

        <h1>{{ __('Code de conduite') }}</h1>

        <p>{{ __("Tous les participants de la communauté Laravel Cameroun doivent respecter notre code de conduite, à la fois en ligne et lors d'événements en personne hébergés et/ou associés à la communauté Laravel Cameroun.") }}</p>

        <h2>{{ __('Notre Engagement') }}</h2>

        <p>{{ __("Dans l'intérêt de favoriser un environnement ouvert et accueillant, nous, en tant que contributeurs et mainteneurs, nous engageons à faire participation à notre projet et à notre communauté une expérience sans harcèlement pour tous, quel que soit l'âge, la taille, handicap, origine ethnique, identité et expression de genre, niveau d'expérience, nationalité, apparence personnelle, race, religion ou identité.") }}</p>

        <h2>{{ __('Nos Standards') }}</h2>

        <p>{{ __('Voici des exemples de comportements qui contribuent à créer un environnement positif :') }}</p>

        <ul>
            <li>{{ __('Utiliser un langage accueillant et inclusif') }}</li>
            <li>{{ __('Être respectueux des points de vue et des expériences différents') }}</li>
            <li>{{ __('Accepter gracieusement les critiques constructives') }}</li>
            <li>{{ __('Se concentrer sur ce qui est le mieux pour la communauté') }}</li>
            <li>{{ __('Faire preuve d\'empathie envers les autres membres de la communauté') }}</li>
        </ul>

        <p>{{ __('Voici des exemples de comportements inacceptables de la part des participants:') }}</p>

        <ul>
            <li>{{ __('L\'utilisation d\'un langage ou d\'images sexualisés et d\'attention ou d\'avances sexuelles indésirables') }}</li>
            <li>{{ __('Troller, commentaires insultants / désobligeants et attaques personnelles ou politiques') }}</li>
            <li>{{ __('Harcèlement public ou privé') }}</li>
            <li>{{ __('Publication des informations privées d\'autrui, telles qu\'une adresse physique ou électronique, sans autorisation explicite') }}</li>
            <li>{{ __('Autre conduite qui pourrait raisonnablement être considérée comme inappropriée dans un cadre professionnel') }}</li>
        </ul>

        <h2>{{ __('Nos Responsabilités') }}</h2>

        <p>{{ __("Les responsables du projet sont responsables de clarifier les normes de comportement acceptable et doivent prendre des mesures correctives appropriées et équitables en réponse à tout cas de comportement inacceptable.") }}</p>

        <p>{{ __("Les responsables du projet ont le droit et la responsabilité de supprimer, modifier ou rejeter les commentaires, les validations, le code, les modifications de wiki, problèmes, et autres contributions qui ne sont pas alignés sur ce code de conduite, ou pour interdire temporairement ou définitivement tout contributeur pour d'autres comportements qu'ils jugent inappropriés, menaçants, offensants ou nuisibles.") }}</p>

        <h2>{{ __('Mise en vigueur') }}</h2>

        <p>{!! __("Les cas de comportement abusif, harcelant ou autrement inacceptable peuvent être signalés en contactant le responsable du projet via l'adresse <a href='mailto:arthur@laravel.cm'>arthur@laravel.cm</a>. L'équipe du projet examinera et enquêtera sur toutes les plaintes, et répondra de manière à ce qu'elle juge approprié aux circonstances. L'équipe de projet est tenue de maintenir la confidentialité en ce qui concerne les journalistes d'un incident. De plus amples détails sur les politiques d'application spécifiques peuvent être publiés séparément.") !!}</p>

        <p>{{ __("Les responsables du projet qui ne respectent pas ou n'appliquent pas le Code de conduite de bonne foi peuvent être confrontés à  des répercussions déterminées par les autres membres de la direction du projet.") }}</p>

        <h2>{{ __('Attribution') }}</h2>

        <p>{!! __('Ce code de conduite est adapté de la <a href="https://www.contributor-covenant.org/version/1/4/code-of-conduct">Convention relative aux contributeurs</a> version 1.4.') !!}</p>

    </div>

@stop
