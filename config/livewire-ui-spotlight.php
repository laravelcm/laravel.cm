<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Shortcuts
    |--------------------------------------------------------------------------
    |
    | Define which shortcuts will activate Spotlight CTRL / CMD + key
    | The default is CTRL/CMD + K or CTRL/CMD + /
    |
    */

    'shortcuts' => [
        'k',
        'slash',
    ],

    /*
    |--------------------------------------------------------------------------
    | Commands
    |--------------------------------------------------------------------------
    |
    | Define which commands you want to make available in Spotlight.
    | Alternatively, you can also register commands in your AppServiceProvider
    | with the Spotlight::registerCommand(Logout::class); method.
    |
    */

    'commands' => [
        \App\Spotlight\Article::class,
        \App\Spotlight\Articles::class,
        \App\Spotlight\Discussion::class,
        \App\Spotlight\Discussions::class,
        \App\Spotlight\FAQs::class,
        \App\Spotlight\Forum::class,
        \App\Spotlight\Guides::class,
        \App\Spotlight\Slack::class,
        \App\Spotlight\Sujet::class,
        \App\Spotlight\Telegram::class,
        \App\Spotlight\User::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Include CSS
    |--------------------------------------------------------------------------
    |
    | Spotlight uses TailwindCSS, if you don't use TailwindCSS you will need
    | to set this parameter to true. This includes the modern-normalize css.
    |
    */
    'include_css' => false,

    /*
    |--------------------------------------------------------------------------
    | Include JS
    |--------------------------------------------------------------------------
    |
    | Spotlight will inject the required Javascript in your blade template.
    | If you want to bundle the required Javascript you can set this to false
    | run `npm install --save fuse.js` and add `require('vendor/livewire-ui/spotlight/resources/js/spotlight');`
    | to your script bundler like webpack.
    |
    */
    'include_js' => true,

];
