<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | SSH Tunnel Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour la création et maintenance d'un tunnel SSH
    | pour l'accès sécurisé aux bases de données distantes.
    |
    */

    'verify_process' => env('SSH_TUNNEL_VERIFY_PROCESS', 'nc'),

    /*
    |--------------------------------------------------------------------------
    | Executable Paths
    |--------------------------------------------------------------------------
    */
    'executables' => [
        'nc' => env('SSH_TUNNEL_NC_PATH', '/usr/bin/nc'),
        'bash' => env('SSH_TUNNEL_BASH_PATH', '/usr/bin/bash'),
        'ssh' => env('SSH_TUNNEL_SSH_PATH', '/usr/bin/ssh'),
        'nohup' => env('SSH_TUNNEL_NOHUP_PATH', '/usr/bin/nohup'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Local Configuration
    |--------------------------------------------------------------------------
    */
    'local' => [
        'address' => env('SSH_TUNNEL_LOCAL_ADDRESS', '127.0.0.1'),
        'port' => env('SSH_TUNNEL_LOCAL_PORT', 3307),
    ],

    /*
    |--------------------------------------------------------------------------
    | Remote Configuration
    |--------------------------------------------------------------------------
    */
    'remote' => [
        'bind_address' => env('SSH_TUNNEL_BIND_ADDRESS', '127.0.0.1'),
        'bind_port' => env('SSH_TUNNEL_BIND_PORT', 3306),
    ],

    /*
    |--------------------------------------------------------------------------
    | SSH Connection
    |--------------------------------------------------------------------------
    */
    'ssh' => [
        'user' => env('SSH_TUNNEL_USER'),
        'hostname' => env('SSH_TUNNEL_HOSTNAME'),
        'port' => env('SSH_TUNNEL_PORT', 22),
        'identity_file' => env('SSH_TUNNEL_IDENTITY_FILE', '~/.ssh/id_rsa'),
        'options' => env('SSH_TUNNEL_SSH_OPTIONS', '-o StrictHostKeyChecking=no'),
        'verbosity' => env('SSH_TUNNEL_VERBOSITY', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Connection Settings
    |--------------------------------------------------------------------------
    */
    'connection' => [
        'wait_microseconds' => env('SSH_TUNNEL_WAIT', 1000000), // 1 second
        'max_tries' => env('SSH_TUNNEL_MAX_TRIES', 3),
        'timeout_seconds' => env('SSH_TUNNEL_TIMEOUT', 30),
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    */
    'logging' => [
        'enabled' => env('SSH_TUNNEL_LOGGING', true),
        'nohup_log' => env('SSH_TUNNEL_NOHUP_LOG', '/dev/null'),
        'channel' => env('SSH_TUNNEL_LOG_CHANNEL', 'single'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-activation
    |--------------------------------------------------------------------------
    */
    'auto_activate' => env('SSH_TUNNEL_AUTO_ACTIVATE', false),
];
