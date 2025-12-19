<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Free Sharable Ads
    |--------------------------------------------------------------------------
    |
    |
    */
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

    /*
    |--------------------------------------------------------------------------
    | Email Support
    |--------------------------------------------------------------------------
    |
    */
    'members' => [
        [
            'name' => 'Arthur Monney',
            'title' => 'Développeur Fullstack',
            'avatar' => 'https://avatars.githubusercontent.com/u/14105989?v=4',
            'social_links' => [
                'twitter' => 'https://twitter.com/MonneyArthur',
                'github' => 'https://github.com/mckenziearts',
                'linkedin' => 'https://www.linkedin.com/in/arthurmonney',
            ],
        ],
        [
            'name' => 'Fabrice Yopa',
            'title' => 'Co-Founder & CTO IS Dev Experts',
            'avatar' => 'https://avatars.githubusercontent.com/u/4902424?v=4',
            'social_links' => [
                'twitter' => 'https://twitter.com/yopafabrice',
                'github' => 'https://github.com/fabriceyopa',
                'linkedin' => 'https://www.linkedin.com/in/fabriceyopa',
            ],
        ],
    ],

    'supported_locales' => ['fr', 'en'],

    'notch-pay-public-token' => env('NOTCHPAY_PUBLIC_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Email Support
    |--------------------------------------------------------------------------
    |
    */
    'support_email' => env('MAIL_SUPPORT', 'support@laravel.cm'),

];
