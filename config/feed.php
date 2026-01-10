<?php

declare(strict_types=1);

use App\Services\FeedAggregator;

return [
    'feeds' => [
        'main' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => [FeedAggregator::class, 'getFeedItems'],

            /*
             * The feed will be available on this url.
             */
            'url' => '/rss',

            'title' => 'Laravel Cameroun - Articles, Discussions & Forum',
            'description' => 'Flux RSS de Laravel Cameroun : articles, discussions et sujets de forum de la communauté Laravel francophone.',
            'language' => 'fr-FR',

            /*
             * The format of the feed.  Acceptable values are 'rss', 'atom', or 'json'.
             */
            'format' => 'rss',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::rss',

            /*
             * The image to display for the feed.
             */
            'image' => '',
        ],
    ],
];
