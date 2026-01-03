<?php

declare(strict_types=1);

use App\Enums\NotificationType;
use App\Livewire\Components\Slideovers\Notifications;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Livewire;

describe(Notifications::class, function (): void {
    beforeEach(function (): void {
        $this->user = $this->login();
    });

    it('renders successfully', function (): void {
        Livewire::test(Notifications::class)
            ->assertStatus(200);
    });

    it('displays unread notifications count', function (): void {
        createNotification($this->user, NotificationType::Mention);
        createNotification($this->user, NotificationType::Reply);

        Livewire::test(Notifications::class)
            ->assertSet('unreadNotificationsCount', 2);
    });

    it('shows has notifications when user has unread notifications', function (): void {
        createNotification($this->user);

        $this->user->refresh();

        expect($this->user->unreadNotifications()->count())->toBeGreaterThan(0);

        Livewire::test(Notifications::class)
            ->assertSet('hasNotifications', true);
    });

    it('shows no notifications when user has no unread notifications', function (): void {
        Livewire::test(Notifications::class)
            ->assertSet('hasNotifications', false);
    });

    it('displays notifications grouped by date', function (): void {
        createNotification($this->user);

        $this->user->refresh();

        expect($this->user->unreadNotifications()->count())->toBeGreaterThan(0);

        $component = Livewire::test(Notifications::class);

        expect($component->viewData('notifications'))
            ->toBeInstanceOf(Collection::class)
            ->and($component->viewData('notifications')->count())
            ->toBeGreaterThan(0);
    });

    it('can mark a notification as read', function (): void {
        $notification = createNotification($this->user);

        expect($notification->read_at)->toBeNull();

        Livewire::test(Notifications::class)
            ->call('markAsRead', $notification->id)
            ->assertDispatched('NotificationMarkedAsRead');

        expect($notification->fresh()->read_at)->not->toBeNull();
    });

    it('dispatches event with correct unread count after marking as read', function (): void {
        $notification1 = createNotification($this->user);
        createNotification($this->user);

        Livewire::test(Notifications::class)
            ->call('markAsRead', $notification1->id)
            ->assertDispatched('NotificationMarkedAsRead', 1);
    });

    it('can mark all notifications as read', function (): void {
        createNotification($this->user);
        createNotification($this->user);
        createNotification($this->user);

        expect($this->user->unreadNotifications()->count())->toBe(3);

        Livewire::test(Notifications::class)
            ->call('markAllAsRead')
            ->assertDispatched('NotificationMarkedAsRead', 0);

        expect($this->user->unreadNotifications()->count())->toBe(0);
    });

    it('cannot mark another user notification as read', function (): void {
        $otherUser = User::factory()->create();
        $notification = createNotification($otherUser);

        Livewire::test(Notifications::class)
            ->call('markAsRead', $notification->id)
            ->assertForbidden();

        expect($notification->fresh()->read_at)->toBeNull();
    });

    it('displays mention notification correctly', function (): void {
        createNotification($this->user, NotificationType::Mention, [
            'author_name' => 'John Doe',
            'replyable_subject' => 'Test Subject',
        ]);

        Livewire::test(Notifications::class)
            ->assertSee('John Doe')
            ->assertSee('Test Subject');
    });

    it('displays reply notification correctly', function (): void {
        createNotification($this->user, NotificationType::Reply, [
            'replyable_subject' => 'Test Thread',
        ]);

        Livewire::test(Notifications::class)
            ->assertSee('Test Thread');
    });

    it('only displays unread notifications', function (): void {
        $unreadNotification = createNotification($this->user);
        $readNotification = createNotification($this->user);
        $readNotification->markAsRead();

        $component = Livewire::test(Notifications::class);

        $notifications = $component->viewData('notifications')->flatten();

        expect($notifications->count())->toBe(1)
            ->and($notifications->first()->id)->toBe($unreadNotification->id);
    });

    it('limits notifications to 10', function (): void {
        for ($i = 0; $i < 15; $i++) {
            createNotification($this->user);
        }

        $component = Livewire::test(Notifications::class);

        $notifications = $component->viewData('notifications')->flatten();

        expect($notifications->count())->toBe(10);
    });
});

/**
 * Helper function to create a database notification
 */
function createNotification(User $user, ?NotificationType $type = null, array $extraData = []): DatabaseNotification
{
    $type = $type ?? NotificationType::Mention;

    $defaultData = [
        'type' => $type->value,
        'author_name' => 'Test Author',
        'author_username' => 'testauthor',
        'author_photo' => 'https://via.placeholder.com/150',
        'replyable_subject' => 'Test Subject',
        'replyable_id' => 1,
        'replyable_type' => App\Models\Thread::class,
    ];

    $notificationData = array_merge($defaultData, $extraData);

    $id = Str::uuid()->toString();

    DB::table('notifications')->insert([
        'id' => $id,
        'type' => App\Notifications\YouWereMentioned::class,
        'notifiable_type' => 'user',
        'notifiable_id' => $user->id,
        'data' => json_encode($notificationData),
        'read_at' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return DatabaseNotification::query()->find($id);
}
