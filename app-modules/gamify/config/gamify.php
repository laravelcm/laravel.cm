<?php

declare(strict_types=1);

return [

    'payee_model' => '\App\Models\User',

    'reputation_model' => '\Laravel\Gamify\Reputation',

    'allow_reputation_duplicate' => true,

    'broadcast_on_private_channel' => true,

    'channel_name' => 'user.reputation.',

];
