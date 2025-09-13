<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PlanType;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Laravelcm\Subscriptions\Interval;
use Laravelcm\Subscriptions\Models\Feature;

final class DeveloperPremiumPlanSeeder extends Seeder
{
    public function run(): void
    {
        $rookiePlan = Plan::query()->create([
            'name' => 'Builder',
            'description' => 'Pour tous ceux qui veulent apprendre et avoir le contenu minimal',
            'type' => PlanType::DEVELOPER,
            'price' => 2000,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => Interval::MONTH->value,
            'trial_period' => 7,
            'trial_interval' => Interval::DAY->value,
            'sort_order' => 1,
            'currency' => 'XAF',
        ]);
        $rookiePlan->features()->saveMany([
            new Feature(['name' => 'Voir les vidéos rookie', 'value' => 1, 'sort_order' => 1]),
            new Feature(['name' => 'Écouter les Podcasts rookie', 'value' => 1, 'sort_order' => 2]),
            new Feature(['name' => 'Badge rookie sur le profil', 'value' => 1, 'sort_order' => 4]),
            new Feature(['name' => 'Accès au code source des tutoriels', 'value' => 1, 'sort_order' => 5]),
        ]);

        $proPlan = Plan::query()->create([
            'name' => 'Artisan',
            'description' => 'Pour les professionnels du métier',
            'type' => PlanType::DEVELOPER,
            'price' => 5000,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => Interval::MONTH->value,
            'trial_period' => 7,
            'trial_interval' => Interval::DAY->value,
            'sort_order' => 1,
            'currency' => 'XAF',
        ]);
        $proPlan->features()->saveMany([
            new Feature(['name' => 'Voir les vidéos premium', 'value' => 1, 'sort_order' => 1]),
            new Feature(['name' => 'Écouter les Podcasts premium', 'value' => 1, 'sort_order' => 2]),
            new Feature(['name' => 'Badge Premium sur le profil', 'value' => 1, 'sort_order' => 3]),
            new Feature(['name' => 'Invitation channel privé sur Discord', 'value' => 1, 'sort_order' => 4]),
            new Feature(['name' => 'Accès au code source des tutoriels premium', 'value' => 1, 'sort_order' => 5]),
            new Feature(['name' => 'E-Books Laravel, Design UI/UX, etc', 'value' => 1, 'sort_order' => 6]),
            new Feature(['name' => '2 heures (2 séances) de consultation mensuelle gratuite', 'value' => 1, 'sort_order' => 9]),
            new Feature(['name' => 'Logo sur la page des articles', 'value' => 1, 'sort_order' => 8]),
        ]);
    }
}
