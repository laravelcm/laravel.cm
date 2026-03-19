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
            'description' => 'Rajouter des notifications sur vos projets Laravel avec Notify.',
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

    /*
    |--------------------------------------------------------------------------
    | AI Bot Author
    |--------------------------------------------------------------------------
    |
    | Email of the user account used to publish AI-generated content
    | (news digests, summaries, etc.). Must match an existing user.
    |
    */
    'ai_author_email' => env('AI_AUTHOR_EMAIL', 'support@laravel.cm'),

    /*
    |--------------------------------------------------------------------------
    | News Digest
    |--------------------------------------------------------------------------
    |
    | Default RSS/Atom sources crawled by the AI news digest command.
    | Admins can override these from the cpanel before each generation.
    |
    */
    'news_digest' => [
        'default_sources' => [
            'https://laravel-news.com/feed',
            'https://laravel.com/feed',
            'https://reddit.com/r/laravel/.rss',
            'https://dev.to/feed/tag/laravel',
            'https://medium.com/feed/tag/laravel',
            'https://laravel.com/feed',
        ],
    ],

];
