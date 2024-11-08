<?php

declare(strict_types=1);

use App\Filament\Resources\TagResource;
use App\Filament\Resources\TagResource\Pages\CreateTag;
use App\Filament\Resources\TagResource\Pages\ListTags;
use App\Models\Tag;
use Filament\Actions\EditAction;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
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

    it('can automatically generate a slug from the title', function (): void {
        $name = fake()->name();

        Livewire::test(CreateTag::class)
            ->fillForm([
                'name' => $name,
            ])
            ->assertFormSet([
                'slug' => Str::slug($name),
            ]);
    });

    it('can validate input is value is null or empty', function (): void {
        $name = fake()->name();

        Livewire::test(CreateTag::class)
            ->fillForm([
                'name' => null,
                'concerns' => [],
                'description' => 'Description du tag '.$name,
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => 'required', 'concerns' => 'required']);
    });

    it('Admin user can create tag', function (): void {
        $name = fake()->name();

        Livewire::test(CreateTag::class)
            ->fillForm([
                'name' => $name,
                'concerns' => ['post', 'tutorial'],
                'description' => 'Description du tag '.$name,
            ])
            ->call('create');
    });

    it('Generate tag if tag already exist', function (): void {

        $name = fake()->name();
        Tag::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'concerns' => ['discussion'],
        ]);

        Livewire::test(CreateTag::class)
            ->fillForm([
                'name' => $name,
                'concerns' => ['post', 'tutorial'],
                'description' => 'Description du tag '.$name,
            ])
            ->call('create');

        expect(Tag::orderByDesc('id')->first()->slug)
            ->toBe(Str::slug($name).'-1');

    });

    it('Admin user can edit tag', function (): void {
        $tag = Tag::factory()->create();

        Livewire::test(ListTags::class)
            ->callTableAction(EditAction::class, $tag, data: [
                'name' => 'Edited tag',
            ])
            ->assertHasNoTableActionErrors();

        $tag->refresh();

        expect($tag->name)
            ->toBe('Edited tag');
    });

})->group('tags');
