<?php

declare(strict_types=1);

return [

    'article' => [
        'created' => 'Votre article a été crée.',
        'submitted' => 'Merci d\'avoir soumis votre article. Vous aurez des nouvelles que lorsque nous accepterons votre article.',
        'updated' => 'Votre article a été mis à jour.',
    ],

    'thread' => [
        'created' => 'Votre sujet à été crée.',
        'updated' => 'Votre sujet à été modifié.',
        'deleted' => 'Le sujet a été supprimé.',
        'best_reply' => 'Vous avez accepté cette solution comme meilleure réponse pour ce sujet.',
        'subscribe' => 'Vous êtes maintenant abonné à ce sujet.',
        'unsubscribe' => 'Vous vous êtes désabonné de ce sujet.',
    ],

    'exceptions' => [
        'unverified_user' => "Vous n'êtes pas autorisé à effectuer cette. Votre e-mail n'est pas vérifiée",
        'spam_exist' => 'Le spam a déjà été signalé.',
        'approved_article' => 'Un article approuvé ne peut pas être modifié.',
    ],

    'reply' => [
        'created' => 'Réponse ajoutée avec succès!',
        'updated' => 'Réponse modifiée avec succès.',
    ],

    'error' => 'Oups! Nous avons rencontré des erreurs.',

    'user' => [
        'banned_title' => 'L\'utilisateur à été banni.',
        'banned_body' => 'L\'utilisateur à été notifier qu\'il à été banni',
        'unbanned_title' => 'L\'utilisateur à été dé-banni',
        'unbanned_body' => 'L\'utilisateur à été notifier qu\'il peut de nouveau se connecter',
        'cannot_ban_title' => 'Impossible de bannir',
        'cannot_ban_body' => 'Cet utilisateur est déjà banni.',
        'cannot_ban_admin' => 'Vous ne pouvez pas bannir un administrateur.',
        'password_changed' => 'Vous avez mis à jour votre mot de passe avec succès',
        'profile_updated' => 'Vous avez mis à jour votre profil avec succès',
    ],

    'spam_send' => 'Votre signalement a été envoyé avec succès',

    'discussion' => [
        'created' => 'Votre discussion à été créée.',
        'updated' => 'Votre discussion à été modifiée.',
        'deleted' => 'Le sujet de discussion a été supprimé.',
        'save_comment' => 'Votre commentaire a été enregistré',
        'delete_comment' => 'Votre commentaire a été supprimé.',
    ],
];
