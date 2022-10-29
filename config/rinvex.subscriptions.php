<?php

declare(strict_types=1);

return [

    // Manage autoload migrations
    'autoload_migrations' => false,

    // Subscriptions Database Tables
    'tables' => [

        'plans' => 'plans',
        'plan_features' => 'plan_features',
        'plan_subscriptions' => 'plan_subscriptions',
        'plan_subscription_usage' => 'plan_subscription_usage',

    ],

    // Subscriptions Models
    'models' => [

        'plan' => \App\Models\Premium\Plan::class,
        'plan_feature' => \App\Models\Premium\Feature::class,
        'plan_subscription' => \App\Models\Premium\Subscription::class,
        'plan_subscription_usage' => \App\Models\Premium\SubscriptionUsage::class,

    ],

];
