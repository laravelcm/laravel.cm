<?php

declare(strict_types=1);

use App\Actions\User\UpdateUserProfileAction;
use App\Livewire\Components\User\Profile;

beforeEach(function (): void {
    $this->user = $this->login();
});

describe(Profile::class, function (): void {
    it('can update user profile', function (): void {
        $data = [
            'location' => 'DRC',
            'username' => 'lcm_user',
        ];
        app(UpdateUserProfileAction::class)
            ->execute($data, $this->user, (string) $this->user->email);

        $this->user->refresh();

        expect($this->user->location)->toBe('DRC');
    });
});
