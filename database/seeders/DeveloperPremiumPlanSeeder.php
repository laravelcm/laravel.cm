<?php

namespace Database\Seeders;

use App\Models\Premium\Feature;
use App\Models\Premium\Plan;
use Illuminate\Database\Seeder;

class DeveloperPremiumPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $rookiePlan = Plan::create([
            'name' => 'Le Rookie',
            'description' => 'Le Rookie plan',
            'type' => \App\Enums\PlanType::DEVELOPER,
            'price' => 2000,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 0,
            'trial_interval' => 'day',
            'sort_order' => 1,
            'currency' => 'XAF',
        ]);
        $rookiePlan->features()->saveMany([
            new Feature(['name' => 'Voir les vidéos premium', 'value' => 1, 'sort_order' => 1]),
            new Feature(['name' => 'Écouter les Podcasts premium', 'value' => 1, 'sort_order' => 2]),
            new Feature(['name' => 'Poster des tutoriels vidéo', 'value' => 1, 'sort_order' => 3]),
            new Feature(['name' => 'Badge Premium sur le profil', 'value' => 1, 'sort_order' => 4]),
            new Feature(['name' => 'Accès au code source des tutoriels', 'value' => 1, 'sort_order' => 5]),
            new Feature(['name' => 'Invitation sur le Github du projet', 'value' => 1, 'sort_order' => 6]),
        ]);

        $proPlan = Plan::create([
            'name' => 'Le Pro',
            'description' => 'Le Pro plan',
            'type' => \App\Enums\PlanType::DEVELOPER,
            'price' => 5000,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 0,
            'trial_interval' => 'day',
            'sort_order' => 1,
            'currency' => 'XAF',
        ]);
        $proPlan->features()->saveMany([
            new Feature(['name' => 'Voir les vidéos premium', 'value' => 1, 'sort_order' => 1]),
            new Feature(['name' => 'Écouter les Podcasts premium', 'value' => 1, 'sort_order' => 2]),
            new Feature(['name' => 'Poster des tutoriels vidéo', 'value' => 1, 'sort_order' => 3]),
            new Feature(['name' => 'Badge Premium sur le profil', 'value' => 1, 'sort_order' => 4]),
            new Feature(['name' => 'Accès au code source des tutoriels', 'value' => 1, 'sort_order' => 5]),
            new Feature(['name' => 'Invitation sur le Github du projet', 'value' => 1, 'sort_order' => 6]),
            new Feature(['name' => 'Invitation channel privé sur Discord', 'value' => 1, 'sort_order' => 7]),
            new Feature(['name' => 'E-Books Laravel, Design UI/UX, etc', 'value' => 1, 'sort_order' => 8]),
            new Feature(['name' => '2 heures (2 séances) de consultation mensuelle gratuite', 'value' => 1, 'sort_order' => 9]),
        ]);
    }
}
