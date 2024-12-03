<?php

declare(strict_types=1);

return [

    'dashboard' => [
        'title' => 'Tableau de bord ~ @:username',
        'stats' => [
            'discussions' => 'Total Article / Discussion',
            'experience' => 'Total Expérience',
            'thread_reply' => 'Total Réponse',
            'thread_resolved' => 'Sujets Résolus',
        ],
    ],

    'account' => [
        'location' => 'Localisation',
        'biography' => 'Biographie',
    ],

    'activities' => [
        'title' => 'Activités',
        'answer_reply' => 'a répondu au sujet',
        'create_article' => 'a rédigé l\'article',
        'create_thread' => 'a lancé le sujet',
        'create_discussion' => 'a démarré une conversation',
        'latest_of' => 'Dernières activités de :name',
        'empty' => 'Aucune activité pour le moment.',
        'empty_articles' => "n'a pas encore rédigé d'articles",
        'empty_discussions' => "n'a pas encore démarrer de discussions",
        'empty_threads' => "n'a pas encore posté de sujets",
    ],

    'settings' => [
        'password_description' => 'Vous devez renseigner votre mot de passe actuel pour changer de mot de passe.',
        'password_helpText' => 'Doit contenir au minimum 8 caractères, avec au moins une majuscule, un chiffre et un caractère spécial.',
        'notifications_title' => 'Gérez vos notifications',
        'notifications_description' => "Cette page répertorie tous les abonnements à des e-mails pour votre compte. Par exemple, vous avez peut-être demandé à être informé par e-mail de la mise à jour d'un thread ou d'un fil de discussion particulier.",
        'preferences_title' => 'Préférences',
        'preferences_description' => 'Définissez vos préférences pour la disposition du site',
        'subscription_title' => 'Souscription',
        'subscription_description' => 'Consulter vos abonnements',
        'profile_title' => 'Mon profil',
        'profile_description' => 'Vous trouverez ci-dessous les informations de votre profil pour votre compte.',
    ],

];
