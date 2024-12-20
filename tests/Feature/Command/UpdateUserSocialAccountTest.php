<?php

declare(strict_types=1);

use App\Console\Commands\UpdateUserSocialAccount;
use App\Models\User;

beforeEach(function (): void {
    $this->user = $this->login([
        'email' => 'joe@laravel.cm',
        'twitter_profile' => 'https://x.com/LaravelCm',
        'github_profile' => 'https://github.com/laravelcm',
        'linkedin_profile' => 'https://www.linkedin.com/in/laravel-cm/',
    ]);

    $this->second_user = User::factory()->create([
        'twitter_profile' => '@shopperLabs',
    ]);
});

describe(UpdateUserSocialAccount::class, function (): void {
    it('can update all user profile with command', function (): void {
        $this->artisan('lcm:update-user-social-account')->assertSuccessful();

        $this->user->refresh();
        $this->second_user->refresh();

        expect($this->user->twitter_profile)
            ->toBe('LaravelCm')
            ->and($this->user->github_profile)
            ->toBe('laravelcm')
            ->and($this->user->linkedin_profile)
            ->toBe('laravel-cm/');

        expect($this->second_user->twitter_profile)
            ->toBe('shopperLabs');
    });
});
