<?php

declare(strict_types=1);

use App\Livewire\Components\Slideovers\DiscussionForm;
use Livewire\Livewire;

/**
 * @var \Tests\TestCase $this
 */
describe(DiscussionForm::class, function (): void {
    it('return redirect to unauthenticated user', function (): void {
        Livewire::test(DiscussionForm::class)
            ->assertMovedPermanently();
    });

    it('render the component when authenticated user', function (): void {
        $this->login();

        Livewire::test(DiscussionForm::class)
            ->assertSuccessful();
    });
})->group('discussion');
