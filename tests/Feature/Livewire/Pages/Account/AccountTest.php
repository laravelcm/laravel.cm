<?php

declare(strict_types=1);

use App\Actions\User\UpdateUserProfileAction;
use App\Events\EmailAddressWasChanged;
use App\Livewire\Pages\Account\Index;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
});

describe(Index::class, function (): void {
    it('renders successfully', function (): void {
        Livewire::test(Index::class)
            ->assertStatus(200);
    });

    it('user can update his profil', function (): void {
        $newUsername = 'testuser_'.uniqid();

        Livewire::test(Index::class)
            ->set('form.name', 'John Doe')
            ->set('form.username', $newUsername)
            ->call('save')
            ->assertHasNoErrors();

        $this->user->refresh();

        expect($this->user->name)->toBe('John Doe')
            ->and($this->user->username)->toBe($newUsername);
    });

    it("user can't update profil if required information was not send", function (): void {
        Livewire::test(Index::class)
            ->set('form.email', '')
            ->call('save')
            ->assertHasErrors(['form.email' => 'required']);

        expect($this->user->email)
            ->toBe($this->user->email);
    })->skip();

    it('can send notification when user email change', function (): void {
        Event::fake([EmailAddressWasChanged::class]);

        $data = ['email' => 'newemail@laravelcm.cm'];

        resolve(UpdateUserProfileAction::class)
            ->execute($data, $this->user, (string) $this->user->email);

        Event::assertDispatched(EmailAddressWasChanged::class);

        $this->user->refresh();

        expect($this->user->email)
            ->toBe('newemail@laravelcm.cm')
            ->and($this->user->email_verified_at)
            ->toBeNull();
    });
});
