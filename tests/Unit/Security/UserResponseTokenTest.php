<?php

declare(strict_types=1);

use App\Traits\UserResponse;

uses(Tests\TestCase::class);

it('creates scoped api tokens with expiration and no PII name', function (): void {
    $reflection = new ReflectionClass(UserResponse::class);
    $source = (string) file_get_contents((string) $reflection->getFileName());

    expect($source)
        ->toContain("name: 'api-session'")
        ->toContain('expiresAt:')
        ->toContain('abilities:')
        ->not->toContain('$user->email)');
});
