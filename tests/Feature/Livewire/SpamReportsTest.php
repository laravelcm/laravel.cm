<?php

declare(strict_types=1);

use App\Actions\ReportSpamAction;
use App\Livewire\ReportSpam;
use App\Models\SpamReport;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    Role::query()->create(['name' => 'admin']);
    Role::query()->create(['name' => 'moderator']);

    Notification::fake();
});

// it('user not allow report a spam on his own reply', function (): void {});

it('does not allow a guest to report content', function (): void {
    $thread = Thread::factory()->create();

    Livewire::test(ReportSpam::class, ['recordId' => $thread->id, 'recordType' => Thread::class])
        ->call('report')
        ->assertForbidden();
});

it('does not allow a user with unverified email to report content', function (): void {
    $user = User::factory()->unverified()->create();
    $this->actingAs($user);

    $thread = Thread::factory()->create();

    Livewire::test(ReportSpam::class, ['recordId' => $thread->id, 'recordType' => Thread::class])
        ->call('report')
        ->assertForbidden();
});

it('allows a verified user to report content', function (): void {
    $user = User::factory()->create(['email_verified_at' => now()]);
    $this->actingAs($user);

    $thread = Thread::factory()->create();

    $this->mock(ReportSpamAction::class)
        ->shouldReceive('execute')
        ->once()
        ->with([
            'user' => $user,
            'recordId' => $thread->id,
            'recordType' => Thread::class,
            'reason' => 'Contenu inapproprié',
        ]);

    Livewire::test(ReportSpam::class, [
        'recordId' => $thread->id,
        'recordType' => Thread::class,
    ])
    ->set('reason', 'Contenu inapproprié')
    ->call('report');
});

it('does not allow a user to report the same content multiple times', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $thread = Thread::factory()->create();

    SpamReport::create([
        'user_id' => $user->id,
        'reportable_id' => $thread->id,
        'reportable_type' => Thread::class,
        'reason' => 'Contenu inapproprié',
    ]);

    $this->mock(ReportSpamAction::class)
        ->shouldNotReceive('execute');

    Livewire::test(ReportSpam::class, [
        'recordId' => $thread->id,
        'recordType' => Thread::class,
    ])
    ->set('reason', 'Même Contenu inapproprié')
    ->call('report')
    ->assertSee('Vous avez déjà signalé ce contenu.');
});

// it('shows a reported badge only to the user who reported the content', function (): void {
//     $reporter = User::factory()->create();
//     $otherUser = User::factory()->create();

//     $article = Article::factory()->create();

//     Livewire::actingAs($reporter)
//         ->test('spam-report-content', ['contentId' => $article->id, 'contentType' => Article::class])
//         ->call('spamReport', 'Contenu inapproprié');

//     Livewire::actingAs($reporter)
//         ->test('spam-report-content', ['contentId' => $article->id, 'contentType' => Article::class])
//         ->assertSee('Badge Signalé');

//     Livewire::actingAs($otherUser)
//         ->test('spam-report-content', ['contentId' => $article->id, 'contentType' => Article::class])
//         ->assertDontSee('Badge Signalé');
// });

// it('sends a notification to admins and moderators when content is reported', function (): void {
//     $user = User::factory()->create();
//     $admin = User::factory()->create();
//     $moderator = User::factory()->create();

//     $admin->assignRole('admin');
//     $moderator->assignRole('moderator');

//     $this->actingAs($user);

//     $article = Article::factory()->create();

//     Livewire::test('spam-report-content', ['contentId' => $article->id, 'contentType' => Article::class])
//         ->call('spamReport', 'Contenu inapproprié');

//     Notification::assertSentTo([$admin, $moderator], ContentReportedSpamNotification::class);
// });

// it('allows an admin to see reported content menu', function (): void {
//     $admin = User::factory()->create();

//     $admin->assignRole('admin');

//     $this->actingAs($admin);

//     Livewire::test('admin-reported-contents')
//         ->call('showReportedContent')
//         ->assertSee('Contenus Signalés');
// });

// it('allows an admin to unmark content as reported', function (): void {
//     $admin = User::factory()->create();

//     $admin->assignRole('admin');

//     $this->actingAs($admin);

//     $article = Article::factory()->create();
//     $report = SpamReport::create([
//         'user_id' => User::factory()->create()->id,
//         'reportable_id' => $article->id,
//         'reportable_type' => Article::class,
//         'reason' => 'Spam',
//     ]);

//     Livewire::test('admin-reported-contents')
//         ->call('unreport', $report->id)
//         ->assertSee('Signalement retiré avec succès');

//     $this->assertDatabaseMissing('reports', [
//         'id' => $report->id,
//     ]);
// });
