<?php

declare(strict_types=1);

use Vormkracht10\FilamentMails\Resources\EventResource;
use Vormkracht10\FilamentMails\Resources\MailResource;

return [
    'resources' => [
        'mail' => MailResource::class,
        'event' => EventResource::class,
    ],
];
