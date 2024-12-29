<?php

declare(strict_types=1);

use App\Actions\User\UpdateUserProfileAction;
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
        Livewire::test(Profile::class, ['user' => $this->user])
            ->fillForm([
                'name' => 'John Doe',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->user->refresh();

        expect($this->user->name)->toBe('John Doe')
            ->and($this->user->email)->toBe($this->user->email);
    });

    it('user can\'t update profil if required information was not send', function (): void {
        Livewire::test(Profile::class, ['user' => $this->user])
            ->fillForm([
                'email' => null,
            ])
            ->call('save')
            ->assertHasFormErrors(['email' => 'required']);

        expect($this->user->email)
            ->toBe($this->user->email);
    });

    it('can send notification when user email change', function (): void {
        Event::fake([EmailAddressWasChanged::class]);

        $data = ['email' => 'newemail@laravelcd.cd'];

        app(UpdateUserProfileAction::class)
            ->execute($data, $this->user, (string) $this->user->email);

        Event::assertDispatched(EmailAddressWasChanged::class);

        $this->user->refresh();

        expect($this->user->email)
            ->toBe('newemail@laravelcd.cm')
            ->and($this->user->email_verified_at)
            ->toBeNull();
    });
});
