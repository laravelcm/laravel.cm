<?php

declare(strict_types=1);

return [

    'deadline_days' => (int) env('SENTINEL_DEADLINE_DAYS', 30), // @phpstan-ignore larastan.noEnvCallsOutsideOfConfig

    'models' => [
        App\Models\Article::class,
        App\Models\Thread::class,
        App\Models\Discussion::class,
        App\Models\Reply::class,
    ],

];
