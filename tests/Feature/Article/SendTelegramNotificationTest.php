<?php

declare(strict_types=1);

use App\Livewire\Articles\Create;
use Livewire\Livewire;
use App\Models\User;

test('Send notification on telegram after submition on article',function(){
// 1- se rassurer que le user est bien connecté
    $user = User::factory()->create();
// 2- soumission d'article par le user connecté
    Livewire::actingAs($user)->test(Create::class)
    ->set('title', 'Test Article')
    ->set('slug', 'test-article')
    ->set('body', 'This is a test article')
    ->set('published_at', now())
    ->set('submitted_at', null)
    ->set('approved_at', null)
    ->set('show_toc', true)
    ->set('canonical_url', 'https://laravel.cm')
    ->set('associateTags', ['tag1', 'tag2'])
    ->store();

// 3- Envois de la notification au modérateur sur un channel telegram

});
