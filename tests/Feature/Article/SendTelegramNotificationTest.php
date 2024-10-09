<?php

declare(strict_types=1);

use App\Livewire\Articles\Create;
use App\Models\Article;
use App\Notifications\PostArticleToTelegram;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
});

test('Send notification on telegram after submition on article', function (): void {

    // 2- soumission d'article par le user connecté
    $file = UploadedFile::fake()->image('article.png');

    $article = Livewire::actingAs($this->user)->test(Create::class)
        ->set('title', 'Test Article')
        ->set('slug', 'test-article')
        ->set('body', 'This is a test article')
        ->set('published_at', now())
        ->set('submitted_at', now())
        ->set('approved_at', null)
        ->set('show_toc', true)
        ->set('file', $file)
        ->set('canonical_url', 'https://laravel.cm')
        ->call('store');

    expect(Article::count())
        ->toBe(1);

    // 3- Envois de la notification au modérateur sur un channel telegram
    if ($article->submitted_at) {
        Notification::assertSentTo(
            notifiable: $this->user,
            notification: PostArticleToTelegram::class
        );
    }

    Notification::assertCount(1);

});
