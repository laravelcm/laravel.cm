<?php

declare(strict_types=1);

use App\Models\Thread;

return [

    'feeds' => [
        'forum' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => [Thread::class, 'getFeedItems'],

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed',

            /*
             * The format of the feed.  Acceptable values are 'rss', 'atom', or 'json'.
             */
            'format' => 'rss',

            'title' => 'Laravel.cd Forum RSS Feed',
        ],
    ],

];
