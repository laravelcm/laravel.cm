<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Channel;
use Illuminate\Database\Seeder;

final class ChannelSeeder extends Seeder
{
    public function run(): void
    {
        $authentification = Channel::create(['name' => 'Authentification', 'slug' => 'authentification', 'color' => '#31c48d']);
        $authentification->items()->createMany([
            ['name' => 'Breeze', 'slug' => 'breeze'],
            ['name' => 'Fortify', 'slug' => 'fortify'],
            ['name' => 'Jetstream', 'slug' => 'jetstream'],
            ['name' => 'Passport', 'slug' => 'passport'],
            ['name' => 'Sanctum', 'slug' => 'sanctum'],
            ['name' => 'UI', 'slug' => 'ui'],
        ]);

        $javascript = Channel::create(['name' => 'JavaScript', 'slug' => 'javascript', 'color' => '#fdae3f']);
        $javascript->items()->createMany([
            ['name' => 'React', 'slug' => 'react'],
            ['name' => 'Vue.js', 'slug' => 'vue-js'],
            ['name' => 'Alpine.js', 'slug' => 'alpine-js'],
        ]);

        $laravel = Channel::create(['name' => 'Laravel', 'slug' => 'laravel', 'color' => '#ff2d20']);
        $laravel->items()->createMany([
            ['name' => 'Blade', 'slug' => 'blade'],
            ['name' => 'Eloquent', 'slug' => 'eloquent'],
            ['name' => 'Request', 'slug' => 'request'],
            ['name' => 'Api', 'slug' => 'api'],
            ['name' => 'Components', 'slug' => 'components'],
            ['name' => 'Socialite', 'slug' => 'socialite'],
            ['name' => 'Packages', 'slug' => 'packages'],
            ['name' => 'Lumen', 'slug' => 'lumen'],
            ['name' => 'Valet', 'slug' => 'valet'],
            ['name' => 'Laragon', 'slug' => 'laragon'],
        ]);

        $framework = Channel::create(['name' => 'Framework', 'slug' => 'framework', 'color' => '#fb70a9']);
        $framework->items()->createMany([
            ['name' => 'Inertia', 'slug' => 'inertia'],
            ['name' => 'Livewire', 'slug' => 'livewire'],
            ['name' => 'TailwindCSS', 'slug' => 'tailwindcss'],
        ]);

        $hosting = Channel::create(['name' => 'Hosting', 'slug' => 'hosting', 'color' => '#0080ff']);
        $hosting->items()->createMany([
            ['name' => 'Digital Ocean', 'slug' => 'digital-ocean'],
            ['name' => 'Forge', 'slug' => 'forge'],
            ['name' => 'Mutualisé', 'slug' => 'mutualise'],
            ['name' => 'Vapor', 'slug' => 'vapor'],
            ['name' => 'S3', 'slug' => 's3'],
            ['name' => 'AWS', 'slug' => 'aws'],
        ]);

        $outils = Channel::create(['name' => 'Outils', 'slug' => 'outils', 'color' => '#333333']);
        $outils->items()->createMany([
            ['name' => 'Github Actions', 'slug' => 'github-actions'],
            ['name' => 'Gitlab', 'slug' => 'gitlab'],
        ]);

        $design = Channel::create(['name' => 'Design', 'slug' => 'design', 'color' => '#6D28D9']);
        $design->items()->createMany([
            ['name' => 'UI/UX', 'slug' => 'ui-ux'],
        ]);

        $divers = Channel::create(['name' => 'Divers', 'slug' => 'divers', 'color' => '#DB2777']);
        $divers->items()->createMany([
            ['name' => 'Laravel.cd', 'slug' => 'laravelcd'],
            ['name' => 'Gaming', 'slug' => 'gaming'],
        ]);
    }
}
