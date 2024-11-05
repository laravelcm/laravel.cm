<?php

declare(strict_types=1);

namespace App\Livewire\Discussions;

use App\Actions\Discussion\CreateDiscussionAction;
use App\Data\CreateDiscussionData;
use App\Models\Tag;
use App\Traits\WithTagsAssociation;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Create extends Component
{
    use WithTagsAssociation;

    #[Validate('required')]
    public string $title = '';

    #[Validate('required')]
    public string $body = '';

    #[On('markdown-x:update')]
    public function onMarkdownUpdate(string $content): void
    {
        $this->body = $content;
    }

    public function store(): void
    {
        $this->validate();

        $discussion = app(CreateDiscussionAction::class)->execute(CreateDiscussionData::from([
            'title' => $this->title,
            'body' => $this->body,
            'tags' => $this->associateTags,
        ]));

        $this->redirectRoute('discussions.show', $discussion, navigate: true);
    }

    public function render(): View
    {
        return view('livewire.discussions.create', [
            'tags' => Tag::whereJsonContains('concerns', ['discussion'])->get(),
        ]);
    }
}
