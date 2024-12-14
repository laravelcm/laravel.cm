<?php

declare(strict_types=1);

use App\Events\EmailAddressWasChanged;
use App\Livewire\Components\User\Profile;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
});

describe(Profile::class, function (): void {
    it('renders successfully', function (): void {
        Livewire::test(Profile::class, ['user' => $this->user])
            ->assertStatus(200);
    });

    it('user can update profil', function (): void {
        Livewire::test(Profile::class)
            ->fillForm([
                'name' => 'John Doe',
            ])
            ->call('updateProfil')
            ->assertHasNoFormErrors();

        $this->user->refresh();

        expect($this->user->name)->toBe('John Doe')
            ->and($this->user->email)->toBe($this->user->email);
    });

    it('user can\'t update profil if email is null', function (): void {
        Livewire::test(Profile::class)
            ->fillForm([
                'email' => null,
            ])
            ->call('updateProfil')
            ->assertHasFormErrors(['email' => 'required']);

        expect($this->user->email)
            ->toBe($this->user->email);
    });

    it('can send notification when user email change', function (): void {
        Event::fake([
            EmailAddressWasChanged::class,
        ]);
        Livewire::test(Profile::class)
            ->fillForm([
                'email' => 'newemail@laravelcm.cm',
            ])
            ->call('updateProfil')
            ->assertHasNoFormErrors();

        Event::assertDispatched(EmailAddressWasChanged::class);

        $this->user->refresh();

        expect($this->user->email)
            ->toBe('newemail@laravelcm.cm')
            ->and($this->user->email_verified_at)
            ->toBeNull();
    });
});
