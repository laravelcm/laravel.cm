<?php

declare(strict_types=1);

use App\Models\User;
use Livewire\Livewire;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;


beforeEach(function (): void {
    Event::fake();
    $this->user = $this->login();
});

describe(UserResource::class, function() {
    it('can ban a user through Filament and send a ban notification', function () {

        $admin = $this->user->assignRole('admin');

        $user = User::factory()->create([
            'banned_at' => null,
            'banned_reason' => null,
        ]);

        $this->actingAs($admin);
    
        Livewire::test(ListUsers::class, ['record' => $user->id])
            ->call('banUser', 'Violation des règles de la communauté')
            ->assertHasNoErrors();

        $user->refresh();
    
        expect($user->banned_at)->not->toBeNull();
        expect($user->banned_reason)->toBe('Violation des règles de la communauté');
    
        Notification::assertSentTo(
            [$user], UserBannedNotification::class
        );
    });
    
});