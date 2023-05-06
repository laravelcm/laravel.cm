<?php

declare(strict_types=1);

// config for Notchpay/Toolkit
return [
    'currency' => [
        'default' => 'XAF',

        /*
        |--------------------------------------------------------------------------
        | API Key for FOREXAPI
        |--------------------------------------------------------------------------
        |
        | Only required if you with to use the Open Exchange Rates api. You can
        | always just use Yahoo, the current default.
        |
        */

        'api_key' => env(
            'RESTUNIVERE_API_KEY',
        ),

        /*
        |--------------------------------------------------------------------------
        | Default Storage Driver
        |--------------------------------------------------------------------------
        |
        | Here you may specify the default storage driver that should be used
        | by the framework.
        |
        | Supported: "database", "filesystem", "model"
        |
        */

        'driver' => 'model',

        /*
        |--------------------------------------------------------------------------
        | Default Storage Driver
        |--------------------------------------------------------------------------
        |
        | Here you may specify the default cache driver that should be used
        | by the framework.
        |
        | Supported: all cache drivers supported by Laravel
        |
        */

        'cache_driver' => "redis",

        /*
        |--------------------------------------------------------------------------
        | Storage Specific Configuration
        |--------------------------------------------------------------------------
        |
        | Here you may configure as many storage drivers as you wish.
        |
        */

        'drivers' => [

            'database' => [
                'class' => \Notchpay\Toolkit\Currency\Drivers\Database::class,
                'connection' => null,
                'table' => 'notchpay_currencies',
            ],

            'filesystem' => [
                'class' => \Notchpay\Toolkit\Currency\Drivers\Filesystem::class,
                'disk' => 'local',
                'path' => 'currencies.json',
            ],

            'model' => [
                'table' => 'notchpay_currencies',
                'class' => \Notchpay\Toolkit\Currency\Models\Currency::class,
            ],

        ],

        /*
        |--------------------------------------------------------------------------
        | Currency Formatter
        |--------------------------------------------------------------------------
        |
        | Here you may configure a custom formatting of currencies. The reason for
        | this is to help further internationalize the formatting past the basic
        | format column in the table. When set to `null` the package will use the
        | format from storage.
        |
        |
        */

        'formatter' => null,

        /*
        |--------------------------------------------------------------------------
        | Currency Formatter Specific Configuration
        |--------------------------------------------------------------------------
        |
        | Here you may configure as many currency formatters as you wish.
        |
        */

        'formatters' => [

            'php_intl' => [
                'class' => \Notchpay\Toolkit\Currency\Formatters\PHPIntl::class,
            ],

        ],
    ],
];
