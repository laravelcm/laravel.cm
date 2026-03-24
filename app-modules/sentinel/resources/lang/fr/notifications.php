<?php

declare(strict_types=1);

return [

    'subject' => 'Problèmes détectés dans vos contenus (:count)',
    'greeting' => 'Bonjour :name,',
    'intro' => 'Nous avons détecté **:count problème(s)** dans vos contenus qui impactent le référencement du site.',
    'deadline' => 'Vous avez **:days jours** pour les corriger. Passé ce délai, les éléments concernés seront automatiquement retirés.',
    'issue_line' => '- **:model** ":title" : :type',
    'action' => 'Connectez-vous pour corriger ces problèmes.',

    'types' => [
        'broken_canonical' => 'URL canonique inaccessible',
        'missing_https' => 'lien sans https://',
        'failed_upload' => 'upload échoué',
    ],

];
