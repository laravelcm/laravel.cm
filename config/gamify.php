<?php

declare(strict_types=1);

use App\Models\User;
use Laravelcm\Gamify\Models\Reputation;

return [
    'payee_model' => User::class,

    'reputation_model' => Reputation::class,

    'allow_reputation_duplicate' => true,

    'broadcast_on_private_channel' => true,

    'channel_name' => 'user.reputation.',
];
