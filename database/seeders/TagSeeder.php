<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

final class TagSeeder extends Seeder
{
    public function run(): void
    {
        $this->createTag('AlpineJS', 'alpinejs', ['post', 'tutorial']);
        $this->createTag('Laravel', 'laravel', ['post', 'tutorial']);
        $this->createTag('Livewire', 'livewire', ['post', 'tutorial']);
        $this->createTag('Inertia', 'inertia', ['post', 'tutorial']);
        $this->createTag('Packages', 'packages', ['post', 'tutorial']);
        $this->createTag('Design', 'design', ['post', 'tutorial']);
        $this->createTag('PHP', 'php', ['post', 'tutorial']);
        $this->createTag('TailwindCSS', 'tailwindcss', ['post', 'tutorial']);
        $this->createTag('JavaScript', 'javascript', ['post', 'tutorial']);
        $this->createTag('Applications', 'applications', ['post', 'tutorial']);
        $this->createTag('React', 'react', ['post', 'tutorial']);
        $this->createTag('Vue.js', 'vue-js', ['post', 'tutorial']);
        $this->createTag('Digital Ocean', 'digital-ocean', ['post', 'tutorial']);
        $this->createTag('Outils', 'outils', ['post', 'discussion', 'tutorial']);
        $this->createTag('Open Source', 'open-source', ['post', 'discussion', 'tutorial']);
        $this->createTag('Salaire', 'salaire', ['discussion']);
        $this->createTag('Entrepreneuriat', 'entrepreneuriat', ['discussion']);
        $this->createTag('Freelance', 'freelance', ['discussion']);
        $this->createTag('Branding', 'branding', ['discussion']);
        $this->createTag('Projets', 'projets', ['discussion']);
        $this->createTag('Paiement en ligne', 'paiement-en-ligne', ['discussion']);
        $this->createTag('Développement', 'developpement', ['discussion']);
        $this->createTag('Event', 'event', ['post']);
        $this->createTag('Tutoriel', 'tutoriel', ['post', 'tutorial']);
        $this->createTag('Communauté', 'communaute', ['post']);
        $this->createTag('Astuces', 'astuces', ['post', 'tutorial']);
        $this->createTag('AWS', 'aws', ['post', 'tutorial']);
        $this->createTag('Linux', 'linux', ['post', 'tutorial']);
        $this->createTag('Serveur', 'serveur', ['post', 'tutorial']);
    }

    private function createTag(string $name, string $slug, array $concerns = []): void
    {
        Tag::factory()->create(compact('name', 'slug', 'concerns'));
    }
}
