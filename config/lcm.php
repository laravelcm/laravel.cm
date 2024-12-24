<?php

declare(strict_types=1);

return [

    'ads' => [
        [
            'url' => 'https://github.com/mckenziearts/laravel-notify/?utm_source=laravel.cm&amp;utm_medium=sidebar-widget',
            'image' => 'notify',
            'alt' => 'Laravel Notify',
            'description' => 'Découvrez la nouvelle version de Laravel Notify pour vos projets Laravel.',
        ],
        [
            'url' => 'https://laravelshopper.dev?utm_source=laravel.cm&amp;utm_medium=sidebar-widget',
            'image' => 'shopper',
            'alt' => 'Laravel Shopper',
            'description' => 'Créez votre boutique en ligne aujourd\'hui avec Laravel Shopper.',
        ],
    ],

    'supported_locales' => ['fr', 'en'],

    'spa_url' => env('FRONTEND_APP_URL', 'http://localhost:4200'),

    'notch-pay-public-token' => env('NOTCHPAY_PUBLIC_KEY', null),

    'support_email' => env('MAIL_SUPPORT', 'support@laravel.cm'),

];
