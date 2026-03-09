<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Lettr API Key
    |--------------------------------------------------------------------------
    |
    | Here you may specify your Lettr API key. This will be used to
    | authenticate with the Lettr API when sending emails.
    |
    */

    'api_key' => env('LETTR_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Template Paths
    |--------------------------------------------------------------------------
    |
    | Configure where pulled templates and generated files should be saved.
    | The html_path is where template HTML files will be stored.
    | The mailable_path and mailable_namespace are used when generating Mailable
    | classes with the --with-mailables option.
    |
    */

    'templates' => [
        'html_path' => resource_path('templates/lettr'),
        'blade_path' => resource_path('views/emails/lettr'),
        'mailable_path' => app_path('Mail/Lettr'),
        'mailable_namespace' => 'App\\Mail\\Lettr',
        'dto_path' => app_path('Dto/Lettr'),
        'dto_namespace' => 'App\\Dto\\Lettr',
        'enum_path' => app_path('Enums'),
        'enum_namespace' => 'App\\Enums',
        'enum_class' => 'LettrTemplate',
    ],

];
