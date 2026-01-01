<?php

declare(strict_types=1);

use App\Actions\User\UpdateUserProfileAction;
use App\Livewire\Pages\Account\Index;

beforeEach(function (): void {
    $this->user = $this->login();
});

describe(Index::class, function (): void {
    it('can update user profile', function (): void {
        $data = [
            'location' => 'Cameroon',
            'username' => 'lcm_user',
        ];
        resolve(UpdateUserProfileAction::class)
            ->execute($data, $this->user, (string) $this->user->email);

        $this->user->refresh();

        expect($this->user->location)->toBe('Cameroon');
    });
});
