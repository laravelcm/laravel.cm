<?php

declare(strict_types=1);

use App\Console\Commands\NotifyPendingArticles;
use App\Models\Article;
use App\Notifications\PendingArticlesNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;

it('will send a notification when there are pending articles', function (): void {
    // Simuler l'envoi d'une fake notification
    Notification::fake();

    //création de l'article et on s'assure qu'elle est en bd.
    $articles = Article::factory()->create(['submitted_at' => now()]);
    $this->assertDatabaseCount('articles', 1);

    // Exécution de la commande lcm:notify-pending-articles
    $this->artisan(NotifyPendingArticles::class)->expectsOutput('✅ Notification sent successfully.')
        ->assertExitCode(0);

    // Vérification qu'une notification à été envoyée pour l'article en attente
    Notification::assertSentTo(
        new AnonymousNotifiable(),
        PendingArticlesNotification::class,
        fn ($notification) => $notification->pendingArticles->contains($articles)
    );
});

it('will not send a notification when there are no pending articles', function (): void {
    Notification::fake();

    $this->artisan(NotifyPendingArticles::class)->expectsOutput('❌ No pending articles found.')
        ->assertExitCode(0);

    // Vérifier qu'aucune notification n'a été envoyée
    Notification::assertNothingSent();
});