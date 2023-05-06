<?php

declare(strict_types=1);

return [

    'ads' => [
        [
            'url' => 'https://github.com/mckenziearts/laravel-notify/?utm_source=laravelcm&amp;utm_medium=sidebar-widget',
            'image' => 'notify',
            'alt' => 'Laravel Notify',
            'description' => 'Découvrez la nouvelle version de Laravel Notify pour vos projets Laravel.',
        ],
        [
            'url' => 'https://laravelshopper.dev?utm_source=laravelcm&amp;utm_medium=sidebar-widget',
            'image' => 'shopper',
            'alt' => 'Laravel Shopper',
            'description' => 'Créez votre boutique en ligne aujourd\'hui avec Laravel Shopper.',
        ],
    ],

    'slack' => [
        'team' => env('SLACK_TEAM_NAME', 'Laravel Cameroun'),
        'url' => env('SLACK_TEAM_URL', 'https://laravelcm.slack.com'),
        'token' => env('SLACK_API_TOKEN', null),
        'web_hook' => env('SLACK_WEBHOOK_URL', ''),
    ],

    'spa_url' => env('FRONTEND_APP_URL', 'http://localhost:4200'),

    'notch-pay-public-token' => env('NOTCHPAY_PUBLIC_KEY', null),

];
