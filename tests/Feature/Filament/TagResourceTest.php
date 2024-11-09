<?php

declare(strict_types=1);

use App\Filament\Resources\TagResource;
use App\Filament\Resources\TagResource\Pages\ListTags;
use App\Models\Tag;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login(['email' => 'joe@laravel.cm']);
    $this->tags = Tag::factory()
        ->count(10)
        ->state(new Sequence(
            ['concerns' => ['post', 'tutorial']],
            ['concerns' => ['post']],
        ))
        ->create();
});

describe(TagResource::class, function (): void {
    it('page can display table with records', function (): void {
        Livewire::test(ListTags::class)
            ->assertCanSeeTableRecords($this->tags);
    });

    it('can validate input is value is null or empty', function (): void {
        $name = fake()->name();

        Livewire::test(ListTags::class)
            ->callAction(CreateAction::class, data: [
                'name' => null,
                'concerns' => [],
                'description' => 'Description du tag '.$name,
            ])
            ->assertHasActionErrors(['name' => 'required', 'concerns' => 'required']);
    });

    it('Admin can create tag', function (): void {
        $name = fake()->name();

        Livewire::test(ListTags::class)
            ->callAction(CreateAction::class, data: [
                'name' => $name,
                'concerns' => ['post', 'tutorial'],
                'description' => 'Description du tag '.$name,
            ])
            ->assertHasNoActionErrors()
            ->assertStatus(200);
    });

    it('Admin can edit tag', function (): void {
        $tag = Tag::factory()->create();

        Livewire::test(ListTags::class)
            ->callTableAction(EditAction::class, $tag, data: [
                'name' => 'Edited tag',
            ])
            ->assertHasNoTableActionErrors();

        $tag->refresh();

        expect($tag->name)->toBe('Edited tag');
    });

})->group('tags');
