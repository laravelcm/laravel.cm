<?php

declare(strict_types=1);

use App\Http\Livewire\Modals\DeclinedArticle;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendDeclinedArticle;
use Spatie\Permission\Models\Role;
use App\Models\Article;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->moderatorUser = User::factory()->create();
    Role::create(['name' => 'moderator']);
    $this->moderatorUser->assignRole('moderator');
    $this->article = Article::factory()->create();

    $this->actingAs($this->moderatorUser);
});

describe(DeclinedArticle::class, function (): void {
    it('Admin or moderator can declined article', function (): void {
        Notification::fake();
        expect($this->article->declined_at)
            ->toBe(null);

        Livewire::actingAs($this->moderatorUser)
            ->test(DeclinedArticle::class, [(int) $this->article->id])
            ->set('raison', 'Manque d\'originalité')
            ->set('description', 'Malheureusement, après une étude approfondie, nous regrettons de vous informer que votre article n\'a pas été sélectionné pour publication dans notre liste d\'article.')
            ->call('declined');

        Notification::assertSentTo(
            [$this->article->user],
            SendDeclinedArticle::class
        );


        expect(Article::findOrFail($this->article->id)->declined_at)
            ->not
            ->toBe(null);
    });
})
    ->group('address');
